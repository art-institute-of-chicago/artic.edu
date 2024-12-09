<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationArticle;

class DigitalPublicationRepository extends ModuleRepository
{
    use HandleBlocks;
    use HandleSlugs;
    use HandleMedias;
    use HandleFiles;
    use HandleRevisions;

    protected $relatedBrowsers = [
        'welcome_note_section' => [
            'relation' => 'welcome_note_section'
        ]
    ];

    public function __construct(DigitalPublication $model)
    {
        $this->model = $model;
    }

    public function getShowData($item, $slug = null, $previewPage = null): array
    {
        return [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'subNav' => null,
            'nav' => null,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'breadcrumb' => [],
            'blocks' => null,
            'page' => $item,
        ];
    }

    public function getWelcomeNote($item): DigitalPublicationArticle
    {
        $welcomeNotes = $item->getRelated('welcome_note_section');

        if (!config('aic.is_preview_mode')) {
            $welcomeNotes = $welcomeNotes->where('published', true);
        }

        return $welcomeNotes->first();
    }
}
