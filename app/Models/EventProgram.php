<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class EventProgram extends AbstractModel
{
    use Transformable;
    use HasFactory;

    protected $fillable = [
        'name',
        'is_affiliate_group',
        'is_event_host',
    ];

    protected $casts = [
        'is_affiliate_group' => 'boolean',
        'is_event_host' => 'boolean',
    ];

    public $attributes = [
        'is_affiliate_group' => false,
        'is_event_host' => false,
    ];

    protected $presenter = 'App\Presenters\Admin\EventProgramPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\EventProgramPresenter';

    public function scopeAffiliateGroups($query): Builder
    {
        return $query->where('is_affiliate_group', true);
    }

    public function scopeEventHosts($query): Builder
    {
        return $query->where('is_event_host', true);
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'name',
                'doc' => 'Name',
                'type' => 'string',
                'value' => function () {
                    return $this->name;
                },
            ],
            [
                'name' => 'is_affiliate_group',
                'doc' => 'Is Affiliate Group',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_affiliate_group;
                },
            ],
            [
                'name' => 'is_event_host',
                'doc' => 'Is Event Host',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_event_host;
                },
            ],
        ];
    }
}
