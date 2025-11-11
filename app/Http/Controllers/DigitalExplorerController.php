<?php

namespace App\Http\Controllers;

use App\Models\DigitalExplorer;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DigitalExplorerController extends Controller
{
    /**
     * Display the specified Digital Explorer
     * Returns view or JSON based on request type
     */
    public function show(DigitalExplorer $digitalExplorer)
    {

        $data = $this->transformExplorer($digitalExplorer);

        // Otherwise, return a view with the data
        return view('site.digitalExplorerDetail', [
            'explorer' => $digitalExplorer,
            'data' => $data
        ]);
    }

    /**
     * Transform the Digital Explorer into a complete data structure
     * This is the HEART of your frontend data engine
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
            ],

            'models' => $digitalExplorer->digitalExplorerModels,
            'lights' => $digitalExplorer->digitalExplorerLights,
            'annotations' => $digitalExplorer->digitalExplorerAnnotations,

            'timestamps' => [
                'created' => $digitalExplorer->created_at?->toIso8601String(),
                'updated' => $digitalExplorer->updated_at?->toIso8601String(),
            ],
        ];
    }

    /**
     * Parse vector strings like "1,2,3" into [x, y, z] arrays
     */
    protected function parseVector(?string $vector): array
    {
        if (!$vector) {
            return [0, 0, 0];
        }

        $parts = array_map('floatval', explode(',', $vector));

        return [
            'x' => $parts[0] ?? 0,
            'y' => $parts[1] ?? 0,
            'z' => $parts[2] ?? 0,
        ];
    }
}