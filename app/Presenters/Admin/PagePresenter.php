<?php

namespace App\Presenters\Admin;

use App\Models\Issue;
use App\Repositories\IssueRepository;

use App\Presenters\BasePresenter;

class PagePresenter extends BasePresenter
{
    private $featuredJournalIssue;

    public function introBlocks()
    {
        return [
            [
                'type' => 'text',
                'content' => '<p>' . $this->entity->exhibition_history_intro_copy . '</p>'
            ]
        ];
    }

    public function exhibitionHistoryMedia()
    {
        return [
            'type' => 'image',
            'size' => 's',
            'media' => $this->entity->imageFront('exhibition_history_intro'),
            'hideCaption' => true
        ];
    }

    public function getFeaturedJournalIssue()
    {
        return $this->featuredJournalIssue ?? $this->featuredJournalIssue = (new IssueRepository(new Issue()))->getLatestIssue();
    }

    public function getFeaturedJournalArticles()
    {
        $featuredJournalArticles = $this->entity->getRelated('featuredJournalArticles')->where('published', true);

        if ($featuredJournalArticles->count() > 0) {
            return $featuredJournalArticles;
        }

        $featuredJournalIssue = $this->getFeaturedJournalIssue();

        if (!$featuredJournalIssue) {
            return;
        }

        return $featuredJournalIssue
            ->present()
            ->articlesForLanding()
            ->slice(0, 4);
    }
}
