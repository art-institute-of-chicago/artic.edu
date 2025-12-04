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

        // Eager load blocks with nested children AND their medias
        $digitalExplorer->load([
            'blocks' => function ($query) {
                $query->with([
                    'children.children.children.children.children',
                    'medias', // Load block medias
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

    /**
     * Transform the Digital Explorer into a complete data structure
     */
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

            // Scene settings from the main form
            'settings' => [
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
                    'position' => [0, 5, 15],
                    'fov' => 75,
                    'near' => 0.1,
                    'far' => 2000
                ]
            ],

            // Transform blocks with full content extraction
            'models' => $this->transformBlocks($digitalExplorer->digital_explorer_models),
            'lights' => $this->transformBlocks($digitalExplorer->digital_explorer_lights),
            'annotations' => $this->transformBlocks($digitalExplorer->digital_explorer_annotations),

            'timestamps' => [
                'created' => $digitalExplorer->created_at?->toIso8601String(),
                'updated' => $digitalExplorer->updated_at?->toIso8601String(),
            ],
        ];
    }

    /**
     * Transform blocks into clean arrays for frontend consumption
     * Recursively handles nested children
     */
    protected function transformBlocks($blocks): array
    {
        return $blocks->map(function ($block) {
            $data = [
                'id' => $block->id,
                'type' => $block->type,
                'position' => $block->position,
                'content' => $block->content ?? [],
            ];

            if ($block->input('modelType')) {
                $data['modelType'] = $block->input('modelType');
            }

            if ($block->file('model') && ($block->input('modelType')) == '3d') {
                $data['modelUrl'] = $block->file('model');
            } elseif ($block->image('image') && ($block->input('modelType')) == '2d') {
                $data['modelUrl'] = $block->imageAsArray('image', 'desktop')['src'];
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

            // Recursively transform children (lights, annotations, nested annotations)
            if ($block->children && $block->children->isNotEmpty()) {
                $data['children'] = $this->transformBlocks($block->children);
            }

            return $data;
        })->values()->all();
    }
}
