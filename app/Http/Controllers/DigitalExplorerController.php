<?php

namespace App\Http\Controllers;

use App\Models\DigitalExplorer;
use App\Repositories\DigitalExplorerRepository;
use App\Helpers\DigitalExplorerHelpers;
use Illuminate\Support\Facades\View;

class DigitalExplorerController extends FrontController
{
    protected $repository;

    public const MIN_ZOOM = 0.0;
    public const MAX_ZOOM = 150.0;
    public const ANNOTATION_DEFAULT_SCALE = 0.07;
    public const ANNOTATION_DEFAULT_COLOR = '#4B9CA3';
    public const ANNOTATION_DEFAULT_ROTATION = [0, 0, 0];
    public const CUSTOM_BOUNDS_DEFAULT = [10.5, 5.2, 8.0];
    public const CUSTOM_BOUNDS_OFFSET_DEFAULT = [0.0, 1.5, 0.0];
    public const CAMERA_POSITION_DEFAULT = [2, 0, 0];
    public const CAMERA_FOV_DEFAULT = 15;
    public const CAMERA_NEAR_DEFAULT = 0.1;
    public const CAMERA_FAR_DEFAULT = 10;


    public function __construct(DigitalExplorerRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id)
    {
        $digitalExplorer = $this->repository->published()->findOrFail($id);

        $digitalExplorer->load([
            'explorerTitleMedia.medias',
            'blocks' => function ($query) {
                $query->with([
                    'children.children.children.children.children',
                    'medias',
                    'children.medias',
                    'children.children.medias',
                ])
                ->orderBy('position');
            }
        ]);

        // Renders paragraph wrapper for style targetting
        View::share(['hasWrapper' => true, 'isDigitalExplorer' => true]);

        $explorerData = $this->transformExplorer($digitalExplorer);

        return view('site.digitalExplorerDetail', [
            'contrastHeader' => false,
            'explorer' => $digitalExplorer,
            'explorerData' => $explorerData,
        ]);
    }

    protected function transformExplorer(DigitalExplorer $digitalExplorer): array
    {
        return [
            'id' => $digitalExplorer->id,
            'title' => $digitalExplorer->title,
            'slug' => $digitalExplorer->slug,
            'type' => $digitalExplorer->type,
            'published' => $digitalExplorer->published,
            'meta_title' => $digitalExplorer->meta_title,
            'meta_description' => $digitalExplorer->meta_description,
            'short_description' => $digitalExplorer->short_description,
            'listing_description' => $digitalExplorer->listing_description,

            'title_data' => [
              'title_media' => $digitalExplorer->explorerTitleMedia->map(function ($media) {
                  $image = $media->imageAsArray('explorer_title_media', 'default');
                  return !empty($image) ? $image : null;
              })->filter()->values()->toArray(),
              'title_display' => $digitalExplorer->title_display
            ],

            'info_card_data' => [
              'info_title' => $digitalExplorer->info_title,
              'info_description' => $digitalExplorer->info_description,
              'info_credits' => $digitalExplorer->info_credits,
            ],

            'settings' => [
                'debug' => $digitalExplorer->settings->get('debug', false),
                'brailleButton' => $digitalExplorer->settings->get('brailleButton', false),
                'builderEnabled' => $digitalExplorer->settings->get('builderEnabled', false),
                'enableCustomBounds' => (bool) $digitalExplorer->settings->get('enableCustomBounds', false),
                'customBounds' => $this->parseCoordinates($digitalExplorer->settings->get('customBounds'), self::CUSTOM_BOUNDS_DEFAULT),
                'customBoundsOffset' => $this->parseCoordinates($digitalExplorer->settings->get('customBoundsOffset'), self::CUSTOM_BOUNDS_OFFSET_DEFAULT),
                'zoomLimits' => DigitalExplorerHelpers::decodeSettings($digitalExplorer->settings->get('zoomLimits'), [self::MIN_ZOOM, self::MAX_ZOOM]),
                'deactivateForcefield' => (bool) $digitalExplorer->settings->get('deactivateForcefield', false),
                'sceneSettings' => [
                    'antialiasing' => (bool) $digitalExplorer->settings?->get('antialiasing', false),
                    'shadows' => (bool) $digitalExplorer->settings?->get('shadows', false),
                ],
                'toneMapping' => $digitalExplorer->settings?->get('toneMapping', 'ACESFilmicToneMapping'),
                'colorSpace' => $digitalExplorer->settings?->get('colorSpace', 'SRGB'),
                'backgroundColor' => $digitalExplorer->settings?->get('backgroundColor', '#1a1a1a'),
                'environmentPreset' => $digitalExplorer->settings?->get('environmentPreset'),
                'toneMappingExposure' => (float) ($digitalExplorer->settings?->get('toneMappingExposure', 1)),
                'orbitControls' => [
                    'target' => [0, 0, 0],
                    'makeDefault' => true
                ],
                'camera' => [
                    'position' => $this->parseCoordinates($digitalExplorer->settings?->get('cameraPosition'), self::CAMERA_POSITION_DEFAULT),
                    'fov' => floatval($digitalExplorer->settings?->get('cameraFov') ?? self::CAMERA_FOV_DEFAULT),
                    'near' => floatval($digitalExplorer->settings?->get('minDistance') ?? self::CAMERA_NEAR_DEFAULT),
                    'far' => intval($digitalExplorer->settings?->get('maxDistance') ?? self::CAMERA_FAR_DEFAULT)
                ]
            ],

            'models' => $this->transformBlocks($digitalExplorer->digital_explorer_models),
            'lights' => $this->transformBlocks($digitalExplorer->digital_explorer_lights),
            'annotations' => $this->transformBlocks($digitalExplorer->digital_explorer_annotations),

            'timestamps' => [
                'created' => $digitalExplorer->created_at?->toIso8601String(),
                'updated' => $digitalExplorer->updated_at?->toIso8601String(),
            ],
        ];
    }

    // Recursively transforms blocks with nested children
    protected function transformBlocks($blocks): array
    {
        return $blocks->map(function ($block) {
            $data = [
                'id' => $block->id,
                'type' => $block->type,
                'position' => $block->position,
                'content' => $block->content ?? [],
            ];

            if ($block->type === 'explorer_annotation') {
                $data['content'] = array_merge($data['content'], [
                    'position' => $this->parseCoordinates($block->input('coordinate'), [0, 0, 0]),
                    'rotation' => $this->parseCoordinates($block->input('rotation'), [0, 0, 0]),
                    'scale' => $this->parseScale($block->input('scale'), self::ANNOTATION_DEFAULT_SCALE),
                    'annotationColor' => $block->input('color') ?: self::ANNOTATION_DEFAULT_COLOR,
                    'annotationSize' => floatval($block->input('scale') ?: self::ANNOTATION_DEFAULT_SCALE),
                    'annotationTarget' => $block->input('annotationTarget'),
                    'annotationZoom' => $block->input('annotationZoom') ? floatval($block->input('annotationZoom')) : null,
                    'showLabel' => (bool) $block->input('showLabel'),
                    'sizeAttenuation' => !((bool) $block->input('sizeAttenuation')),
                    'labelText' => $block->input('label') ?? '',
                ]);

                if ($block->hasImage('icon')) {
                    $data['content']['annotationIcon'] = $block->image('icon', 'default');
                }
            } elseif ($block->type === 'explorer_model') {
                $data['content'] = array_merge($data['content'], [
                    'label' => $block->input('label') ?? '',
                    'position' => $this->parseCoordinates($block->input('coordinate'), [0, 0, 0]),
                    'rotation' => $this->parseCoordinates($block->input('rotation'), [0, 0, 0]),
                    'scale' => $this->parseScale($block->input('scale'), 1.0),
                ]);
            }

            if ($block->input('modelType')) {
                $data['modelType'] = $block->input('modelType');
            }

            if ($block->file('model') && ($block->input('modelType')) == '3d') {
                $data['modelUrl'] = $block->file('model');
            } elseif ($block->image('image') && ($block->input('modelType')) == '2d') {
                $data['modelUrl'] = isset($block->imageAsArray('image', 'desktop')['src']) ? $block->imageAsArray('image', 'desktop')['src'] : null;
            }

            if ($block->file('thumbnail')) {
                $data['thumbnailUrl'] = $block->image('thumbnail', 'default', [
                    'w' => 400,
                    'h' => 400,
                ]);
            }

            if ($block->file('image')) {
                $data['imageUrl'] = $block->image('image', 'default');
            }

            if ($block->file('environment_map')) {
                $data['environmentMapUrl'] = $block->file('environment_map');
            }

            if ($block->children && $block->children->isNotEmpty()) {
                $data['children'] = $this->transformBlocks($block->children);
                $data['renderedHtml'] = $this->renderBlockChildren($block);
            }

            return $data;
        })->values()->all();
    }

    // Parses "[x, y, z]" string into float array
    protected function parseCoordinates(?string $coordinates, array $default = [0, 0, 0]): array
    {
        if (!$coordinates) {
            return $default;
        }

        $coordinates = trim($coordinates, '[]');
        $parts = array_map('trim', explode(',', $coordinates));

        if (count($parts) === 3) {
            return [
                floatval($parts[0]),
                floatval($parts[1]),
                floatval($parts[2])
            ];
        }

        return $default;
    }

    protected function parseScale(?string $scale, float $default = 1.0): float
    {
        if (!$scale) {
            return $default;
        }

        return floatval($scale);
    }



    protected function renderBlockChildren($parentBlock): string
    {
        if (!$parentBlock->children || $parentBlock->children->isEmpty()) {
            return '';
        }

        $html = '';
        foreach ($parentBlock->children as $child) {
            $html .= $this->renderSingleBlock($child, $parentBlock);
        }

        return $html;
    }

    // Renders block using its Blade view (site.blocks.{type})
    public function renderSingleBlock($block, $parentBlock = null): string
    {
        $viewPath = "site.blocks.{$block->type}";

        if (view()->exists($viewPath)) {
            $renderHelper = $this->createRenderHelper($block);

            return view($viewPath, [
                'block' => $block,
                'renderData' => $renderHelper
            ])->render();
        }

        if ($block->children && $block->children->isNotEmpty()) {
            $html = '';
            foreach ($block->children as $child) {
                $html .= $this->renderSingleBlock($child, $block);
            }
            return $html;
        }

        return '';
    }

    // Helper object that mimics RenderData's renderChildren method
    protected function createRenderHelper($block): object
    {
        return new class ($block, $this) {
            protected $block;
            protected $controller;

            public function __construct($block, $controller)
            {
                $this->block = $block;
                $this->controller = $controller;
            }

            public function renderChildren(?string $fieldName = null): string
            {
                if (!$this->block->children || $this->block->children->isEmpty()) {
                    return '';
                }

                $html = '';
                foreach ($this->block->children as $child) {
                    if ($fieldName && ($child->child_key ?? null) !== $fieldName) {
                        continue;
                    }
                    $html .= $this->controller->renderSingleBlock($child, $this->block);
                }

                return $html;
            }
        };
    }
}
