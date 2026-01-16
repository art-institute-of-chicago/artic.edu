<?php

// app/Models/DigitalExplorerLight.php

namespace App\Models;

class DigitalExplorerLight extends AbstractModel
{
    protected $fillable = [
        'digital_explorer_id',
        'position',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function digitalExplorer()
    {
        return $this->belongsTo(DigitalExplorer::class);
    }

    /**
     * Prepare data for Twill's repeater form
     * This flattens the settings array into dot-notation for form population
     */
    public function toRepeaterArray(): array
    {
        $data = [
            'id' => $this->id,
            'position' => $this->position,
        ];

        // Flatten settings with dot notation
        if ($this->settings && is_array($this->settings)) {
            foreach ($this->settings as $key => $value) {
                $data["settings.{$key}"] = $value;
            }
        }

        return $data;
    }
}
