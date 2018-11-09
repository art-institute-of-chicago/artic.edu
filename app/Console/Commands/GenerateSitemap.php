<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Event;
use App\Models\Exhibition;
use App\Models\PrintedCatalog;
use App\Models\DigitalCatalog;
use App\Models\GenericPage;

use App\Repositories\GenericPageRepository;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use Symfony\Component\DomCrawler\Link;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

use Illuminate\Console\Command;

class GenerateSitemap extends Command
{

    protected $signature = 'sitemap:generate';

    protected $description = 'Command to generate a sitemap file';

    private $prefix;

    private $path;

    public function handle()
    {
        $this->prefix = 'https://' .(config('sitemap.base_url') ?? config('app.url'));
        $this->path = public_path('sitemap.xml');

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

        // $this->info('Importing collections data...');
        // $this->addRemoteModels($sitemap);

        $sitemap->writeToFile($this->path);
        $this->warn('Sitemap saved! See ' . $this->path);
    }

    // See `routes/web.php` and the `pages` table for the full list
    private function addHardcodedPages(&$sitemap)
    {
        $this->addRoute($sitemap, 'home', 1.0);
        $this->addRoute($sitemap, 'visit', 1.0);
        $this->addRoute($sitemap, 'events', 0.9);
        $this->addRoute($sitemap, 'collection', 0.9);
        $this->addRoute($sitemap, 'articles_publications');
        $this->addRoute($sitemap, 'articles');
        $this->addRoute($sitemap, 'exhibitions.history', 0.6);
        $this->addRoute($sitemap, 'exhibitions', 1.0);
        $this->addRoute($sitemap, 'exhibitions.upcoming', 0.9);
        $this->addRoute($sitemap, 'about.press');
        $this->addRoute($sitemap, 'about.press.archive', 0.6);
        $this->addRoute($sitemap, 'collection.publications.printed-catalogs', 0.6);
        $this->addRoute($sitemap, 'collection.publications.digital-catalogs', 0.6);
        $this->addRoute($sitemap, 'collection.research_resources');
        $this->addRoute($sitemap, 'collection.resources.research-guides');
        $this->addRoute($sitemap, 'collection.resources.educator-resources');
    }

    // Adapted from App\Http\Controllers\Admin\GenericPageController
    private function addGenericPages(&$sitemap)
    {
        $repository = new GenericPageRepository(new GenericPage());

        // Depth is included automatically alongside id
        $pages = $repository->withDepth()->defaultOrder()->published();

        foreach ($pages->cursor() as $page)
        {
            if ($page->depth > 2) {
                continue;
            }

            $url = $page->url;

            if (starts_with($url, 'http')) {
                continue;
            }

            if (!starts_with($url, '/')) {
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
        $this->addNativeModel($sitemap, PrintedCatalog::class, 'collection.publications.printed-catalogs.show', 0.7, Url::CHANGE_FREQUENCY_MONTHLY);
        $this->addNativeModel($sitemap, DigitalCatalog::class, 'collection.publications.digital-catalogs.show', 0.7, Url::CHANGE_FREQUENCY_MONTHLY);
    }

    // get <a/>'s to filters, artworks, and category-terms from /collection
    private function addCollection(&$sitemap)
    {
        $file = $this->prefix . route('collection', [], false);

        if( !$html = @file_get_contents( $file ) )
        {
            throw new \Exception('Fetch failed: ' . $file );
        }

        $domCrawler = new DomCrawler($html, $file);

        $links = collect($domCrawler->filterXpath('//a')->links())->map(function (Link $link) {
            return $link->getUri();
        })->filter(function (string $url) {
            $path = parse_url($url, PHP_URL_PATH);
            return (
                // Eliminate buggy paths that lead nowhere
                empty(parse_url($url, PHP_URL_FRAGMENT)) && !ends_with($url, '#')
            ) && (
                // Keep links to filters and top artworks
                ends_with($path, 'collection') || strpos($path, 'artworks') !== false
            ) && (
                // ...but don't link to the collection itself
                !ends_with($url, 'collection')
            );
        })->unique()->values()->map(function (string $url) use (&$sitemap) {
            // TODO: Collect last updated times for these pages..?
            $this->addUrl($sitemap, $url, 0.8, Url::CHANGE_FREQUENCY_WEEKLY);
        });
    }

    /**
     * TODO: Make the datahub provide this information. For now, we only list augmented exhibitions.
     */
    private function addExhibitions(&$sitemap)
    {
        $this->addNativeModel($sitemap, Exhibition::class, 'exhibitions.show', 0.9, Url::CHANGE_FREQUENCY_WEEKLY, 'datahub_id');
    }

    private function addRemoteModels(&$sitemap)
    {
        // 'artworks.show'
        // 'galleries.show'
        // 'artists.show'
        // 'departments.show'
    }

    // Anything paginated and CMS-native of format `/resources/{id}/{slug}`
    private function addNativeModel(&$sitemap, $class, string $route, float $priority = 0.8, $changeFrequency = Url::CHANGE_FREQUENCY_DAILY, $idField = 'id')
    {
        // `id` is always needed for retrieving slugs
        $fields = array_values(array_unique([$idField, 'id', 'updated_at']));

        foreach ($class::select($fields)->cursor() as $entity)
        {
            $this->addUrl($sitemap, route($route, [
                'id' => $entity->$idField,
                'slug' => $entity->slug
            ], false), $priority, $changeFrequency, $entity->updated_at);
        }
    }

    // Used by addHardcodedPages
    private function addRoute(&$sitemap, string $route, float $priority = 0.8, $changeFrequency = Url::CHANGE_FREQUENCY_DAILY)
    {
        $this->addUrl($sitemap, route($route, [] , false), $priority, $changeFrequency);
    }

    // Set everything in one call
    private function addUrl(&$sitemap, string $url, float $priority = 0.8, $changeFrequency = Url::CHANGE_FREQUENCY_DAILY, $lastModified = null)
    {
        $url = URL::create(trim($url, '/'));
        $url->setPriority($priority);
        $url->setChangeFrequency($changeFrequency);

        if ($lastModified)
        {
            $url->setLastModificationDate($lastModified);
        }

        $this->add($sitemap, $url);
    }

    // Ensures everything is prefixed w/ SITEMAP_BASE_URL
    private function add(&$sitemap, $url)
    {
        if (is_string($url) && !starts_with($url, $this->prefix)) {
            $url = $this->prefix . $url;
        } else if ($url instanceof Url && !starts_with($url->url, $this->prefix)) {
            $url->setUrl($this->prefix . $url->url);
        }

        $sitemap->add($url);
    }

}
