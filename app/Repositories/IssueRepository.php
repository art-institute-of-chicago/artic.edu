<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Models\Issue;

class IssueRepository extends ModuleRepository
{
    use HandleSlugs, HandleMedias, HandleRevisions;

    protected $relatedBrowsers = [
        'welcome_note_article' => [
            'relation' => 'welcome_note_article'
        ]
    ];

    public function __construct(Issue $model)
    {
        $this->model = $model;
    }

    public function getLatestIssue()
    {
        return Issue::query()->published()->orderBy('date', 'desc')->first();
    }

    public function getWelcomeNote($item)
    {
        $welcomeNotes = $item->getRelated('welcome_note_article');

        if (!config('aic.is_preview_mode')) {
            $welcomeNotes = $welcomeNotes->where('published', true);
        }

        return $welcomeNotes->first();
    }
}
