<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Models\Behaviors\HasPresenter;

class MyMuseumTour extends Model
{
    use HasPresenter;

    protected $presenter = 'App\Presenters\Admin\DigitalPublicationArticlePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\DigitalPublicationArticlePresenter';

    protected $connection;

    public function __construct()
    {
        $this->connection = 'tours';
    }

    protected $fillable = ['id', 'creator_email', 'marketing_opt_in', 'confirmation_sent', 'tour_json', 'timestamp'];

    protected $casts = ['tour_json' => 'array'];

    public function scopeNotSent($query): Builder
    {
        $query->where('confirmation_sent', false);
        $query->whereNotNull('pdf_download_path');
        return $query;
    }
}
