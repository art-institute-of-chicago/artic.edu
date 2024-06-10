<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Event;
use App\Models\Exhibition;
use App\Models\PrintedPublication;
use App\Models\DigitalPublication;
use App\Models\GenericPage;
use App\Repositories\GenericPageRepository;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\DomCrawler\Link;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Command to generate a sitemap file';

    private $prefix;

    private $crawlPrefix;

    private $path;

    public function handle()
    {
        $this->prefix = config('sitemap.base_url') ?? ('https://' . config('app.url'));
        $this->prefix = rtrim($this->prefix, '/');

        $this->crawlPrefix = config('sitemap.crawl_url') ?? $this->prefix;
        $this->crawlPrefix = rtrim($this->crawlPrefix, '/');

        $this->path = storage_path('app/sitemap.xml');

        $this->warn('Generating new sitemap! Domain is ' . $this->prefix);
        $sitemap = Sitemap::create();

        $this->info('Gathering hardcoded pages...');
        $this->addHardcodedPages($sitemap);

        $this->info('Gathering native models...');
        $this->addNativeModels($sitemap);

        $this->info('Gathering generic pages...');
        $this->addGenericPages($sitemap);

        $this->info('Gathering exhibitions...');
        $this->addExhibitions($sitemap);

        $this->info('Crawling links on collection landing...');
        $this->addCollection($sitemap);

        $sitemap->writeToFile($this->path);
        $this->warn('Sitemap saved! See ' . $this->path);
    }

    /**
     * Add routes for all non-module pages
     * @see `routes/web.php` and the `pages` table for the full list
     */
    private function addHardcodedPages(&$sitemap)
    {
        $this->addRoute($sitemap, 'home', 1.0);
        $this->addUrl($sitemap, route('pages.slug', ['slug' => 'visit']), 1.0);
        $this->addRoute($sitemap, 'events', 0.9);
        $this->addRoute($sitemap, 'collection', 0.9);
        $this->addRoute($sitemap, 'articles_publications');
        $this->addRoute($sitemap, 'articles');
        $this->addRoute($sitemap, 'exhibitions.history', 0.6);
        $this->addRoute($sitemap, 'exhibitions', 1.0);
        $this->addRoute($sitemap, 'exhibitions.upcoming', 0.9);
        $this->addRoute($sitemap, 'about.press');
        $this->addRoute($sitemap, 'about.press.archive', 0.6);
        $this->addRoute($sitemap, 'collection.publications.printed-publications', 0.6);
        $this->addRoute($sitemap, 'collection.publications.digital-publications', 0.6);
        $this->addRoute($sitemap, 'collection.research_resources');
        $this->addRoute($sitemap, 'collection.resources.educator-resources');
    }

    /**
     * Add all generic pages
     * @see App\Http\Controllers\Admin\GenericPageController
     */
    private function addGenericPages(&$sitemap)
    {
        $repository = new GenericPageRepository(new GenericPage());

        // Depth is included automatically alongside id
        $pages = $repository->withDepth()->defaultOrder()->published();

        foreach ($pages->cursor() as $page) {
            if ($page->depth > 2) {
                continue;
            }

            $url = $page->url;

            if (Str::startsWith($url, 'http')) {
                continue;
            }

            if (!Str::startsWith($url, '/')) {
                $url = '/' . $url;
            }

            // Don't go through the routes on this one
            $this->addUrl($sitemap, $url, 0.8, Url::CHANGE_FREQUENCY_WEEKLY, $page->updated_at);
        }
    }

    private function addNativeModels(&$sitemap)
    {
        $this->addNativeModel($sitemap, Event::class, 'events.show', 0.8, Url::CHANGE_FREQUENCY_WEEKLY);
        $this->addNativeModel($sitemap, Article::class, 'articles.show', 0.7, Url::CHANGE_FREQUENCY_MONTHLY);
        $this->addNativeModel($sitemap, PrintedPublication::class, 'collection.publications.printed-publications.show', 0.7, Url::CHANGE_FREQUENCY_MONTHLY, function ($entity) {
            return ['id' => $entity->id, 'slug' => $entity->getSlug()];
        });
        $this->addNativeModel($sitemap, DigitalPublication::class, 'collection.publications.digital-publications.show', 0.7, Url::CHANGE_FREQUENCY_MONTHLY, function ($entity) {
            return ['id' => $entity->id, 'slug' => $entity->getSlug()];
        });
    }

    /**
     * Get links to filters, artworks, and category-terms from /collection
     */
    private function addCollection(&$sitemap)
    {
        $file = $this->crawlPrefix . route('collection', [], false);

        if (!$html = @file_get_contents($file)) {
            throw new \Exception('Fetch failed: ' . $file);
        }

        $domCrawler = new DomCrawler($html, $file);

        $links = collect($domCrawler->filterXpath('//a')->links())->map(function (Link $link) {
            return $link->getUri();
        })->filter(function (string $url) {
            $path = parse_url($url, PHP_URL_PATH);

            return (
                // Eliminate buggy paths that lead nowhere
                empty(parse_url($url, PHP_URL_FRAGMENT)) && !Str::endsWith($url, '#')
            ) && (
                // Keep links to filters and top artworks
                Str::endsWith($path, 'collection') || strpos($path, 'artworks') !== false
            ) && (
                // ...but don't link to the collection itself
                !Str::endsWith($url, 'collection')
            );
        })->unique()->values()->map(function (string $url) use (&$sitemap) {
            // WEB-2246: Collect last updated times for these pages?
            $this->addUrl($sitemap, $url, 0.8, Url::CHANGE_FREQUENCY_WEEKLY);
        });
    }

    /**
     * TODO: Make the datahub provide this information. For now, we only list augmented exhibitions.
     */
    private function addExhibitions(&$sitemap)
    {
        $this->addNativeModel($sitemap, Exhibition::class, 'exhibitions.show', 0.9, Url::CHANGE_FREQUENCY_WEEKLY, function ($entity) {
            return [
                'id' => $entity->datahub_id,
                'slug' => $entity->slug,
            ];
        }, ['datahub_id']);
    }

    private function addRemoteModels(&$sitemap)
    {
    }

    /**
     * Add a URL by module
     * Anything paginated and CMS-native of format `/resources/{id}/{slug}`
     */
    private function addNativeModel(&$sitemap, $class, string $route, float $priority = 0.8, $changeFrequency = Url::CHANGE_FREQUENCY_DAILY, $paramCallback = null, $additionalFields = [])
    {
        // `id` is always needed for retrieving slugs
        $fields = array_values(array_unique(array_merge($additionalFields, ['id', 'updated_at'])));

        foreach ($class::select($fields)->cursor() as $entity) {
            $params = $paramCallback ? $paramCallback($entity) : [
                'id' => $entity->id,
                'slug' => $entity->slug
            ];

            $this->addUrl($sitemap, route($route, $params, false), $priority, $changeFrequency, $entity->updated_at);
        }
    }

    /**
     * Add a URL by route
     * Used by addHardcodedPages
     */
    private function addRoute(&$sitemap, string $route, float $priority = 0.8, $changeFrequency = Url::CHANGE_FREQUENCY_DAILY)
    {
        $this->addUrl($sitemap, route($route, [], false), $priority, $changeFrequency);
    }

    /**
     * Add a URL to the sitemap
     * Set everything in one call
     */
    private function addUrl(&$sitemap, string $url, float $priority = 0.8, $changeFrequency = Url::CHANGE_FREQUENCY_DAILY, $lastModified = null)
    {
        $url = URL::create(trim($url, '/'));
        $url->setPriority($priority);
        $url->setChangeFrequency($changeFrequency);

        if ($lastModified) {
            $url->setLastModificationDate($lastModified);
        }

        $this->add($sitemap, $url);
    }

    /**
     * Add to the sitemap
     * Ensures everything is prefixed w/ SITEMAP_BASE_URL
     */
    private function add(&$sitemap, $url)
    {
        $tmpUrl = $url->url ?? $url;

        foreach ([$this->prefix, $this->crawlPrefix] as $prefix) {
            if (substr($tmpUrl, 0, strlen($prefix)) == $prefix) {
                $tmpUrl = substr($tmpUrl, strlen($prefix));
            }
        }

        $tmpUrl = Str::startsWith($tmpUrl, '/') ? $tmpUrl : '/' . $tmpUrl;
        $tmpUrl = $this->prefix . $tmpUrl;

        if (is_string($url)) {
            $url = $tmpUrl;
        } elseif ($url instanceof Url) {
            $url->setUrl($tmpUrl);
        }

        $sitemap->add($url);
    }
}
