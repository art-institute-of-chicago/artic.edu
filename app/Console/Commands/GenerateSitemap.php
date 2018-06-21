<?php

namespace App\Console\Commands;

use Spatie\Sitemap\SitemapGenerator;
use Spatie\Crawler\Crawler;

use Illuminate\Console\Command;


class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate a sitemap file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        SitemapGenerator::create(config('app.url'))->configureCrawler(function (Crawler $crawler) {
        $crawler->setMaximumDepth(3);
    })->writeToFile(public_path('sitemap.xml'));

    }
}
