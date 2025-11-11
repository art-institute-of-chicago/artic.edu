<?php
// app/Models/DigitalExplorerAnnotation.php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasBlocks;

class DigitalExplorerAnnotation extends AbstractModel
{
    use HasMedias;
    use HasBlocks;

    protected $fillable = [
        'digital_explorer_id',
        'position',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public $mediasParams = [
        'icon' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
    ];


    public function digitalExplorer()
    {
        return $this->belongsTo(DigitalExplorer::class);
    }

    public function toRepeaterArray(): array
    {
        $data = [
            'id' => $this->id,
            'position' => $this->position,
        ];

        // Flatten settings
        if ($this->settings && is_array($this->settings)) {
            foreach ($this->settings as $key => $value) {
                $data["settings.{$key}"] = $value;
            }
        }

        // Handle medias
        if (method_exists($this, 'mediasParams')) {
            foreach ($this->mediasParams as $role => $crops) {
                $data['medias'][$role] = $this->medias
                    ->where('role', $role)
                    ->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'crop' => $media->pivot->crop ?? 'default',
                        ];
                    })
                    ->toArray();
            }
        }

        // Handle blocks - properly formatted for Twill repeaters
        if ($this->relationLoaded('blocks')) {
            $data['blocks'] = $this->blocks->toArray();
        }

        return $data;
    }
}