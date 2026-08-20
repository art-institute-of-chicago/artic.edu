<?php

namespace App\Http\Controllers;

use App\Repositories\DigitalPublicationArticleRepository;
use App\Libraries\SchemaOrg\SchemaMapper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class DigitalPublicationArticleController extends FrontController
{
    protected $repository;

    public function __construct(DigitalPublicationArticleRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function show($pubId, $pubSlug, $id, $slug = null)
    {
        $item = $this->repository->published()->findOrFail($id);

        $canonicalPath = $item->present()->getCanonicalUrl();

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->list_description);
        $this->seo->setImage($item->imageFront('hero'));

        $this->seo->citationTitle = $item->meta_title ?: $item->title;
        $this->seo->citationPublisher = 'The Art Institute of Chicago';

        if ($item->authors) {
            foreach ($item->authors as $author) {
                $this->seo->citationAuthor[] = $author->title;
            }
        } else {
            $this->seo->citationAuthor[] = $item->author_display;
        }

        if ($item->date) {
            $this->seo->citationPublicationDate = $item->date->toDateString();
            $this->seo->citationOnlineDate = $item->date->toDateString();
        }

        if ($item->digitalPublication->is_unlisted) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

        View::share('itemType', Str::slug(title: $item->type));

        $this->addJsonLd($item);

        return view('site.digitalPublicationArticleDetail', [
            'item' => $item,
            'contrastHeader' => false,
            'borderlessHeader' => false,
            'unstickyHeader' => true,
            'canonicalUrl' => $canonicalPath,
            'bgcolor' => $item->digitalPublication->bgcolor,
            'pdfDownloadPath' => $item->present()->pdfDownloadPath(),
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
        $articleAuthors = static function ($m) {
            $authors = [];

            if (!empty($m->authors)) {
                foreach ($m->authors as $author) {
                    if (empty($author->title)) {
                        continue;
                    }

                    $entry = [
                        '@type' => 'Person',
                        'name' => $author->title,
                    ];

                    $id = $author->id ?? null;

                    if (!empty($id)) {
                        $slug = method_exists($author, 'getSlug') ? $author->getSlug() : null;

                        $url = route('authors.show', ['id' => $id, 'slug' => $slug]);

                        if ($url !== null) {
                            $entry['url'] = $url;
                        }
                    }

                    $authors[] = $entry;
                }
            }

            if (empty($authors) && !empty($m->author_display)) {
                $authors[] = [
                    '@type' => 'Person',
                    'name' => $m->author_display,
                ];
            }

            return empty($authors) ? null : $authors;
        };

        $articleKeywords = static function ($m) {
            try {
                $categories = $m->categories ?? collect();
            } catch (\Throwable $e) {
                $categories = collect();
            }

            if (!($categories instanceof \Traversable)) {
                return null;
            }

            $names = collect($categories)
                ->map(static fn ($category) => is_object($category) ? ($category->name ?? null) : ($category['name'] ?? null))
                ->filter()
                ->unique()
                ->values();

            return $names->isEmpty() ? null : $names->implode(', ');
        };

        $publicationArticleUrl = static function ($m) {
            if (empty($m->id)) {
                return null;
            }

            try {
                $publication = $m->digitalPublication ?? null;
            } catch (\Throwable $e) {
                $publication = null;
            }

            $pubId = is_object($publication) ? ($publication->id ?? null) : null;
            $pubSlug = is_object($publication) && method_exists($publication, 'getSlug') ? $publication->getSlug() : null;

            try {
                return route(
                    'collection.publications.digital-publications-articles.show',
                    [
                        'pubId' => $pubId,
                        'pubSlug' => $pubSlug,
                        'id' => $m->id,
                        'slug' => method_exists($m, 'getSlug') ? $m->getSlug() : null,
                    ]
                );
            } catch (\Throwable $e) {
                return null;
            }
        };

        $publicationArticleIsPartOf = static function ($m) {
            try {
                $publication = $m->digitalPublication ?? null;
            } catch (\Throwable $e) {
                $publication = null;
            }

            if (!$publication || empty($publication->id)) {
                return null;
            }

            $slug = method_exists($publication, 'getSlug') ? $publication->getSlug() : null;

            try {
                $publicationUrl = route(
                    'collection.publications.digital-publications.show',
                    [
                        'id' => $publication->id,
                        'slug' => $slug,
                    ]
                );
            } catch (\Throwable $e) {
                return null;
            }

            return [
                '@type' => 'Book',
                '@id' => $publicationUrl,
                'name' => $publication->title ?? null,
            ];
        };

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => static fn ($m) => ($m->article_type ?? $m->articleType ?? 'article') === 'editorial' ? 'BlogPosting' : 'Article',
                'headline' => 'title',
                'description' => SchemaMapper::text('description', 'heading', 'list_description'),
                'abstract' => SchemaMapper::text('list_description'),
                'thumbnailUrl' => static fn ($m, $mapper) => $mapper->thumbnailUrl(),
                'datePublished' => SchemaMapper::iso('date'),
                'dateModified' => static fn ($m, $mapper) => $mapper->toIso8601($m->updated_at ?? $m->date ?? null),
                'author' => $articleAuthors,
                'publisher' => SchemaMapper::orgRef(),
                'mainEntityOfPage' => $publicationArticleUrl,
                'articleSection' => static function ($m) {
                    $value = $m->article_type ?? $m->articleType ?? 'article';

                    return $value instanceof \BackedEnum ? (string) $value->value : $value;
                },
                'keywords' => $articleKeywords,
                'url' => $publicationArticleUrl,
                'isPartOf' => $publicationArticleIsPartOf,
            ]
        );
    }
}
