<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Facades\TwillPermissions;
use A17\Twill\Http\Controllers\Admin\Controller;
use App\Libraries\BlockCopy;
use App\Libraries\BlockCopyException;
use App\Models\Vendor\Block;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

/** Server-rendered block copy admin page (source block -> target record). */
class BlockCopyController extends Controller
{
    /** Query keys carried between the copy/paste round trip. */
    private const PARAMS = ['source_module', 'source_record', 'target_module', 'target_record'];

    public function index(Request $request): View
    {
        $modules = BlockCopy::modules();

        $errors = [];

        $sourceModule = $this->moduleOrNull($request->query('source_module'), $modules);
        $targetModule = $this->moduleOrNull($request->query('target_module'), $modules);

        $sourceOptions = $sourceModule ? BlockCopy::recordOptions($sourceModule) : [];
        $targetOptions = $targetModule ? BlockCopy::recordOptions($targetModule) : [];

        $sourceRecord = $this->resolveRecord($sourceModule, $request->query('source_record'), 'source_record', $errors);
        $targetRecord = $this->resolveRecord($targetModule, $request->query('target_record'), 'target_record', $errors);

        $targetAllowed = $targetModule ? BlockCopy::allowedBlocks($targetModule) : null;
        $lastPasteId = Session::get('blockCopy.lastPasteId');

        $sourceBlocks = $sourceRecord ? BlockCopy::blockList($sourceRecord, $targetAllowed) : [];
        $targetBlocks = $targetRecord ? BlockCopy::blockList($targetRecord, null, $lastPasteId) : [];

        $blockCopyData = [
            'source' => ['module' => $sourceModule, 'record' => $sourceRecord?->getKey(), 'blocks' => $sourceBlocks],
            'target' => ['module' => $targetModule, 'record' => $targetRecord?->getKey(), 'blocks' => $targetBlocks],
        ];

        $view = view('twill.blockCopy.index', [
            'modules' => $modules,
            'sourceModule' => $sourceModule,
            'sourceRecord' => $sourceRecord,
            'sourceOptions' => $sourceOptions,
            'sourceBlocks' => $sourceBlocks,
            'targetBlocks' => $targetBlocks,
            'targetModule' => $targetModule,
            'targetRecord' => $targetRecord,
            'targetOptions' => $targetOptions,
            'targetChosen' => $targetRecord !== null,
            'blockCopyData' => $blockCopyData,
        ]);

        return $errors ? $view->withErrors($errors) : $view;
    }

    /** JSON snapshot of the current source/target selections for the fetch-driven page. */
    public function data(Request $request): JsonResponse
    {
        $modules = BlockCopy::modules();

        $sourceModule = $this->moduleOrNull($request->query('source_module'), $modules);
        $targetModule = $this->moduleOrNull($request->query('target_module'), $modules);

        $sourceErrors = [];
        $targetErrors = [];

        $sourceRecord = $this->resolveRecord($sourceModule, $request->query('source_record'), 'source_record', $sourceErrors);
        $targetRecord = $this->resolveRecord($targetModule, $request->query('target_record'), 'target_record', $targetErrors);

        $targetAllowed = $targetModule ? BlockCopy::allowedBlocks($targetModule) : null;

        return response()->json([
            'modules' => $this->moduleList($modules),
            'source' => $this->columnData($sourceModule, $sourceRecord, $sourceErrors, $targetAllowed),
            'target' => $this->columnData($targetModule, $targetRecord, $targetErrors, null),
        ]);
    }

    public function paste(Request $request): RedirectResponse|JsonResponse
    {
        $json = $request->expectsJson();
        $id = $request->input('block_id');

        if (!is_numeric($id) || !($source = Block::find((int) $id))) {
            return $this->pasteFailure($request, "Block '{$id}' not found.", $json);
        }

        $this->authorizeModule($request, $this->aliasFor($source->blockable_type));

        $targetModule = (string) $request->input('target_module');
        $targetRecord = $request->input('target_record');
        $position = $request->input('position');

        if ($targetModule === '' || !is_numeric($targetRecord)) {
            return $this->pasteFailure($request, 'Pick a target module and record.', $json);
        }

        $this->authorizeModule($request, $targetModule);

        if ($position === null || $position === '') {
            $position = null;
        } elseif (!is_numeric($position) || (int) $position < 1) {
            return $this->pasteFailure($request, 'Position must be a positive integer.', $json);
        } else {
            $position = (int) $position;
        }

        try {
            $result = BlockCopy::copy($source, $targetModule, (int) $targetRecord, $position);
        } catch (BlockCopyException $e) {
            return $this->pasteFailure($request, $e->getMessage(), $json);
        }

        $clone = $result['clone'];

        $message = sprintf(
            'Pasted block %s → new block %s (%s) on %s:%s (children: %d, media rows: %d)',
            $source->getKey(),
            $clone->getKey(),
            $clone->type,
            $targetModule,
            $targetRecord,
            $result['children'],
            $result['media']
        );

        if ($json) {
            Session::flash('blockCopy.lastPasteId', $clone->getKey());

            return $this->pasteJson($request, $clone, $targetModule, (int) $targetRecord, $message);
        }

        Session::flash('blockCopy.lastPasteId', $clone->getKey());

        Session::flash('status', $message);

        return $this->back($request);
    }

    /** Persists a new block-editor order for one editor group on a target record. */
    public function reorder(Request $request): JsonResponse
    {
        $modules = BlockCopy::modules();
        $module = $this->moduleOrNull((string) $request->input('module', ''), $modules);

        if ($module === null) {
            return response()->json(['errors' => ['reorder' => "Unknown target module '{$request->input('module')}'."]], 422);
        }

        $recordId = $request->input('record');
        $class = BlockCopy::modelClass($module);
        $record = is_numeric($recordId) && $class ? $class::find((int) $recordId) : null;

        if (!$record) {
            return response()->json(['errors' => ['reorder' => 'Pick a module and record.']], 422);
        }

        $this->authorizeModule($request, $module);

        $editor = $request->input('editor');
        $editor = $editor === null || $editor === '' ? null : (string) $editor;

        $ids = $request->input('ids', []);

        if (!is_array($ids)) {
            $ids = [];
        }

        try {
            $result = BlockCopy::reorder($record, $ids, $editor);
        } catch (BlockCopyException $e) {
            return response()->json(['errors' => ['reorder' => $e->getMessage()]], 422);
        }

        return response()->json([
            'ok' => true,
            'blocks' => $result['blocks'],
            'total' => count($result['blocks']),
        ]);
    }

    /** Builds the JSON payload for one column of the data endpoint. */
    private function columnData(?string $module, $record, array $errors, ?array $allowed): array
    {
        $title = $record && is_scalar($record->title) ? (string) $record->title : null;

        return [
            'module' => $module,
            'record' => $record?->getKey(),
            'title' => $title,
            'options' => $module ? $this->optionList(BlockCopy::recordOptions($module)) : [],
            'blocks' => $record ? BlockCopy::blockList($record, $allowed) : [],
            'error' => $errors ? (string) reset($errors) : null,
        ];
    }

    /** @param array<string, array{label: string}> $modules */
    private function moduleList(array $modules): array
    {
        $list = [];

        foreach ($modules as $alias => $module) {
            $list[] = ['alias' => $alias, 'label' => $module['label']];
        }

        return $list;
    }

    /** @param array<int|string, string> $options */
    private function optionList(array $options): array
    {
        $list = [];

        foreach ($options as $id => $label) {
            $list[] = ['id' => (int) $id, 'label' => $label];
        }

        return $list;
    }

    /** JSON/redirect error for the paste endpoint. */
    private function pasteFailure(Request $request, string $message, bool $json): RedirectResponse|JsonResponse
    {
        if ($json) {
            return response()->json(['errors' => ['paste' => $message]], 422);
        }

        return $this->back($request)->withErrors(['paste' => $message]);
    }

    /** JSON success payload with the clone row and refreshed source/target block lists. */
    private function pasteJson(
        Request $request,
        Block $clone,
        string $targetModule,
        int $targetRecord,
        string $message
    ): JsonResponse {
        $class = BlockCopy::modelClass($targetModule);
        $target = $class ? $class::find($targetRecord) : null;

        $targetBlocks = $target ? BlockCopy::blockList($target, null, $clone->getKey()) : [];

        $cloneRow = null;

        foreach ($targetBlocks as $row) {
            if ($row['id'] === $clone->getKey()) {
                $cloneRow = $row;
                break;
            }
        }

        $modules = BlockCopy::modules();
        $sourceModule = $this->moduleOrNull((string) $request->input('source_module'), $modules);
        $sourceErrors = [];
        $sourceRecord = $this->resolveRecord(
            $sourceModule,
            $request->input('source_record'),
            'source_record',
            $sourceErrors
        );

        return response()->json([
            'ok' => true,
            'message' => $message,
            'clone' => $cloneRow,
            'target' => ['module' => $targetModule, 'record' => $targetRecord, 'blocks' => $targetBlocks],
            'source' => [
                'blocks' => $sourceRecord
                    ? BlockCopy::blockList($sourceRecord, BlockCopy::allowedBlocks($targetModule))
                    : [],
            ],
        ]);
    }

    /** Aborts with 403 when the user may not edit the module (only enforced for permissionable modules). */
    private function authorizeModule(Request $request, ?string $alias): void
    {
        if ($alias === null || !TwillPermissions::enabled() || !TwillPermissions::getPermissionModule($alias)) {
            return;
        }

        abort_unless($request->user()->can('edit-module', $alias), 403, "You do not have permission to edit {$alias}.");
    }

    /** Maps a stored blockable_type (alias or class name) back to a module alias. */
    private function aliasFor(?string $blockableType): ?string
    {
        if ($blockableType === null) {
            return null;
        }

        $alias = array_search($blockableType, Relation::morphMap(), true);

        return is_string($alias) ? $alias : null;
    }

    /** Returns the alias when it is a known module, else null. */
    private function moduleOrNull(?string $alias, array $modules): ?string
    {
        return $alias !== null && isset($modules[$alias]) ? $alias : null;
    }

    /** Resolves a record by numeric id first, else by title, collecting user-facing errors. */
    private function resolveRecord(?string $alias, $value, string $errorKey, array &$errors)
    {
        if ($alias === null || $value === null || $value === '') {
            return null;
        }

        $class = BlockCopy::modelClass($alias);

        if (!$class) {
            $errors[$errorKey] = "Unknown module '{$alias}'.";

            return null;
        }

        $record = is_numeric($value)
            ? $class::find((int) $value)
            : $class::query()->where('title', $value)->first();

        if (!$record) {
            $errors[$errorKey] = "No record '{$value}' found on {$alias}.";

            return null;
        }

        return $record;
    }

    /** Redirects back to the index preserving the current query params. */
    private function back(Request $request): RedirectResponse
    {
        return redirect()->route('twill.general.blockCopy.index', $request->only(self::PARAMS));
    }
}
