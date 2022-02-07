<?php

namespace App\Libraries\Search\Filters;

class Departments extends BaseFilteredList
{
    protected $parameter = 'department_ids';
    protected $entity = \App\Models\Api\Department::class;

    // ART-48, WEB-1831: Combine library and archives into one filter
    const RESEARCH_TITLE = 'Research Center';

    private string $archiveTitle;
    private string $libraryTitle;

    private $hiddenDepartments;

    public function __construct($buckets, $aggregationName)
    {
        parent::__construct(...func_get_args());

        $this->archiveTitle = config('aic.department_archive_title');
        $this->libraryTitle = config('aic.department_library_title');

        $this->hiddenDepartments = [
            'PC-826' => $this->archiveTitle,
            'PC-824' => $this->libraryTitle,
        ];

        $archive = $this->buckets->firstWhere('key', $this->archiveTitle);
        $library = $this->buckets->firstWhere('key', $this->libraryTitle);

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
                'placeholder' => 'Find Departments',
                'title' => 'Departments',
                'active' => $this->activeList,
                'list' => $sortedList,
                'listSearch' => false,
                'showMore' => false,
                'type' => 'list',
                'aggregation' => $this->aggregationName,
                'listSearchUrl' => route('collection.categorySearch', request()->except(['categoryQuery']) + ['categoryName' => 'departments'])
            ];
        }
    }

    public function findLabel($key)
    {
        return ucfirst($key);
    }

    public static function handleResearchCenter($ids)
    {
        return empty($ids) ? $ids : str_replace(self::RESEARCH_TITLE, implode(';', [
            config('aic.department_archive_title'),
            config('aic.department_library_title'),
        ]), $ids);
    }
}
