<?php

namespace App\Http\Controllers;

use App\Models\DigitalExplorer;
use App\Repositories\DigitalExplorerRepository;
use Illuminate\Support\Facades\Response;

class DigitalExplorerController extends FrontController
{
    protected $repository;

    public function __construct(DigitalExplorerRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id)
    {
        $digitalExplorer = $this->repository->published()->findOrFail($id);

        $digitalExplorer->load([
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

        $explorerData = $this->transformExplorer($digitalExplorer);

        return view('site.digitalExplorerDetail', [
            'contrastHeader' => true,
            'explorer' => $digitalExplorer,
            'explorerData' => $explorerData
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
              'title_media' => $digitalExplorer->image('title_media'),
              'title_display' => $digitalExplorer->title_display
            ],

            'settings' => [
                'debug' => $digitalExplorer->settings?->get('debug', false),
                'sceneSettings' => [
                    'antialiasing' => in_array('antialiasing', $digitalExplorer->settings?->get('sceneSettings', []) ?? []),
                    'shadows' => in_array('shadows', $digitalExplorer->settings?->get('sceneSettings', []) ?? []),
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
                    'position' => [2, 0, 0],
                    'fov' => 75,
                    'near' => 0.1,
                    'far' => 2000
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
                    'scale' => $this->parseScale($block->input('scale'), 1.0),
                    'annotationColor' => $block->input('color') ?: '#4ecdc4',
                    'annotationSize' => floatval($block->input('scale') ?: 0.5),
                    'annotationTarget' => $block->input('annotationTarget'),
                    'showLabel' => in_array('showLabel', $block->input('annotationSettings') ?? []),
                    'sizeAttenuation' => !in_array('sizeAttenuation', $block->input('annotationSettings') ?? []),
                    'labelText' => $block->input('label') ?? '',
                ]);

                if ($block->hasImage('icon')) {
                    $data['content']['annotationIcon'] = $block->image('icon', 'default');
                }
            } elseif ($block->type === 'explorer_model') {
                $data['content'] = array_merge($data['content'], [
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
                    $html .= $this->controller->renderSingleBlock($child, $this->block);
                }

                return $html;
            }
        };
    }
}
