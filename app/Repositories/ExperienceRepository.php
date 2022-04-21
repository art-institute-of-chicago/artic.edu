<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Experience;
use App\Models\Article;
use App\Repositories\Behaviors\HandleExperienceModule;
use App\Repositories\Behaviors\HandleMagazine;
use App\Repositories\Behaviors\HandleAuthors;

class ExperienceRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions, HandleExperienceModule, HandleMagazine, HandleAuthors;

    protected $morphType = 'experiences';

    public function __construct(Experience $model)
    {
        $this->model = $model;
    }

    public function getCountByStatusSlug($slug, $scope = [])
    {
        $scope = $scope + ['archived' => false];

        return parent::getCountByStatusSlug($slug, $scope);
    }

    public function create($fields)
    {
        $experience = parent::create($fields);
        $attract_fields = [
            'title' => 'Attract',
            'module_type' => 'attract',
            'experience_id' => $experience->id,
            'published' => true,
        ];
        $end_fields = [
            'title' => 'End',
            'module_type' => 'end',
            'experience_id' => $experience->id,
            'published' => true,
        ];
        app(\App\Repositories\SlideRepository::class)->create($attract_fields);
        app(\App\Repositories\SlideRepository::class)->create($end_fields);

        return $experience;
    }

    public function search($search)
    {
        return Experience::where('title', 'ILIKE', "%{$search}%")->published()->notUnlisted();
    }

    public function order($query, array $orders = [])
    {
        if (array_key_exists('interactiveFeatureTitle', $orders)) {
            $sort_method = $orders['interactiveFeatureTitle'];
            unset($orders['interactiveFeatureTitle']);
            $query = $query->orderByInteractiveFeature($sort_method);
        }
        // Don't forget to call the parent order function
        return parent::order($query, $orders);
    }


    public function getFurtherReadingTitle($item)
    {
        if ($this->isInMagazine($item) && $item->is_unlisted) {
            return 'Also in this Issue';
        }

        return 'Further Reading';
    }

    public function getFurtherReadingItems($item)
    {
        if ($item->is_in_magazine && $item->is_unlisted) {
            return $this->getAlsoInThisIssue($item);
        }

        return Article::published()
            ->orderBy('date', 'desc')
            ->notUnlisted()
            ->paginate(4);
    }
}
