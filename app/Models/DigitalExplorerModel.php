<?php

// app/Models/DigitalExplorerModel.php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;

class DigitalExplorerModel extends AbstractModel
{
    use HasFiles;

    protected $fillable = [
        'digital_explorer_id',
        'position',
        'settings',
        'model_settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'model_settings' => 'array',
    ];

    public $filesParams = [
        'modelFile' => [
            'role' => 'modelFile',
        ]
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

        // Handle model_settings array (for multi-select)
        if ($this->model_settings && is_array($this->model_settings)) {
            $data['modelSettings'] = $this->model_settings;
        }

        // Handle files
        if (method_exists($this, 'filesParams')) {
            foreach ($this->filesParams as $role => $params) {
                $data['files'][$role] = $this->getRelated('files')
                    ->where('role', $role)
                    ->pluck('id')
                    ->toArray();
            }
        }

        return $data;
    }
}
