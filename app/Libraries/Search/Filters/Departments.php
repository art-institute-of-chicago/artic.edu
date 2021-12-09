<?php

namespace App\Libraries\Search\Filters;

class Departments extends BaseFilteredList
{
    protected $parameter  = 'department_ids';
    protected $entity     = \App\Models\Api\Department::class;

    // ART-48, WEB-1831: "Research Center" combines library and archives
    const RESEARCH_TITLE = 'Research Center';
    const ARCHIVE_TITLE = 'AIC Archives';
    const LIBRARY_TITLE = 'Ryerson and Burnham Libraries Special Collections';

    private $hiddenDepartments = [
        'PC-826' => self::ARCHIVE_TITLE,
        'PC-824' => self::LIBRARY_TITLE,
    ];

    public function __construct($buckets, $aggregationName)
    {
        parent::__construct(...func_get_args());

        $archive = $this->buckets->firstWhere('key', self::ARCHIVE_TITLE);
        $library = $this->buckets->firstWhere('key', self::LIBRARY_TITLE);

        if ($archive || $library) {
            $this->buckets->push((object) [
                'key' => self::RESEARCH_TITLE,
                'doc_count' => ($archive->doc_count ?? 0) + ($library->doc_count ?? 0),
            ]);
        }
    }

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        $sortedDepartments = $list->pluck('label')->sort()->diff($this->hiddenDepartments)->values();

        $sortedList = $sortedDepartments->map(function ($title) use ($list) {
            return $list->firstWhere('label', $title);
        })->filter();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => "Find Departments",
                'title'       => "Departments",
                'active'      => $this->activeList,
                'list'        => $sortedList,
                'listSearch'  => false,
                'showMore'    => false,
                'type'        => 'list',
                'aggregation' => $this->aggregationName,
                'listSearchUrl' => route('collection.categorySearch', request()->except(['categoryQuery']) + ['categoryName' => 'departments'])
            ];
        }
    }

    public function findLabel($key)
    {
        return ucfirst($key);
    }
}
