<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class PagePresenter extends BasePresenter
{
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

    public function currentFeaturedExhibitions() {
        return $this->entity->apiModels('exhibitionsExhibitions', 'Exhibition')->filter(function ($exhibition) {
            return !$exhibition->is_closed;
        });
    }

    public function upcomingFeaturedExhibitions() {
        return $this->entity->apiModels('exhibitionsUpcoming', 'Exhibition')->filter(function ($exhibition) {
            return $exhibition->is_upcoming;
        });
    }

    public function currentListedExhibitions() {
        return $this->entity->apiModels('exhibitionsCurrent', 'Exhibition')->filter(function ($exhibition) {
            return !$exhibition->is_closed;
        });
    }

    public function upcomingListedExhibitions() {
        return $this->entity->apiModels('exhibitionsUpcomingListing', 'Exhibition')->filter(function ($exhibition) {
            return $exhibition->is_upcoming;
        });
    }
}
