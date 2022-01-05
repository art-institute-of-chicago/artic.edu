<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMediasEloquent;

class Mirador extends AbstractModel
{
    use HasSlug, HasMedias, HasMediasEloquent, HasRevisions, HasFiles, HasBlocks, Transformable;

    protected $presenter = 'App\Presenters\Admin\MiradorPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\MiradorPresenter';

    protected $fillable = [
        'published',
        'title',
        'date',
        'object_id',
        'upload_manifest_file',
        'default_view',
    ];

    protected $dates = [
        'date',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published'
    ];

    public $filesParams = ['upload_manifest_file'];

    const SINGLE_VIEW = 'single';
    const BOOK_VIEW = 'book';

    public static $viewTypes = [
        self::SINGLE_VIEW => 'single',
        self::BOOK_VIEW => 'book',
    ];

    public function getMiradorManifest()
    {
        if ($this->object_id or $this->file('upload_manifest_file')) {
            if ($this->file('upload_manifest_file')) {
                $manifestFile = $this->file('upload_manifest_file');
            } else {
                $manifestFile = config('api.public_uri') . '/api/v1/artworks/' . $this->object_id . '/manifest.json';
            }

            return $manifestFile;
        }
    }
}
