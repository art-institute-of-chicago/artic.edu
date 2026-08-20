<?php

namespace App\Http\Controllers;

use App\Repositories\MagazineIssueRepository;
use App\Libraries\SchemaOrg\SchemaMapper;
use Illuminate\Support\Carbon;

class MagazineIssueController extends FrontController
{
    protected $repository;

    public function __construct(MagazineIssueRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function latest()
    {
        $issue = $this->repository->getLatestIssue();

        return $this->show($issue->id, $issue->getSlug(), true);
    }

    public function show($id, $slug = null, $isRequestForLatest = false)
    {
        $item = $this->repository->published()->findOrFail($id);
        $canonicalPath = route('magazine-issues.show', ['id' => $item->id, 'slug' => $item->getSlug()]);

        if (!$isRequestForLatest) {
            if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
                return $canonicalRedirect;
            }
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->list_description); // Issues have no blocks
        $this->seo->setImage($item->imageFront('hero'));

        $this->addJsonLd($item);

        $issuesByYear = $this->repository
            ->published()
            ->ordered()
            ->get()
            ->mapToGroups(function ($issue) {
                $year = (new Carbon($issue->publish_start_date))->year;
                return [$year => $issue];
            });
        $issueArchive = ['title' => 'Archive', 'items' => []];
        foreach ($issuesByYear as $year => $yearIssues) {
            $byYear = ['title' => (string)$year];
            foreach ($yearIssues as $issue) {
                $byYear['items'][] = ['title' => $issue->title, 'url' => route('magazine-issues.show', [$issue])];
            }
            $issueArchive['items'][] = $byYear;
        }

        return view('site.magazineIssueDetail', [
            'item' => $item,
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'issues' => [$issueArchive],
            'welcomeNote' => $this->repository->getWelcomeNote($item),
            'canonicalUrl' => $canonicalPath,
        ]);
    }

    /**
     * The schema.org definition for the given model.
     *
     * Shared defaults (e.g. inLanguage) come from the parent; page-specific
     * properties defined here are merged over them.
     *
     * @param mixed $model The model to map.
     *
     * @return array<string, mixed>
     */
    protected function jsonLdDefinition(mixed $model): array
    {
        $optionalField = static function (string $field) {
            return static function ($m) use ($field) {
                $value = $m->{$field} ?? null;

                if (is_numeric($value) || (is_string($value) && $value !== '')) {
                    return (string) $value;
                }

                return null;
            };
        };

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => 'PublicationIssue',
                'datePublished' => SchemaMapper::iso('publish_start_date'),
                'url' => SchemaMapper::canonical('magazine-issues.show'),
                'mainEntityOfPage' => SchemaMapper::canonical('magazine-issues.show'),
                'isPartOf' => [
                    '@type' => 'Periodical',
                    'name' => 'Art Institute of Chicago magazine',
                ],
                'issueNumber' => $optionalField('issue_number'),
            ]
        );
    }
}
