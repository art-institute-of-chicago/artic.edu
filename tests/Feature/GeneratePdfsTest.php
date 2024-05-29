<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Console\Commands\GeneratePdfs;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationArticle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GeneratePdfsTest extends BaseTestCase
{
    protected Collection $articles;

    protected function setUp(): void
    {
        parent::setUp();
        $this->articles = DigitalPublicationArticle::factory()
            ->count(2)
            ->published()
            ->for(DigitalPublication::factory()->published())
            ->create();
        Http::fake();
    }

    public function test_generate_command_successful(): void
    {
        $this->artisan('pdfs:generate')
            ->assertSuccessful()
            ->expectsOutput("Generated PDF for DigitalPublicationArticle with ID {$this->articles->first()->id}")
            ->expectsOutput("Generated PDF for DigitalPublicationArticle with ID {$this->articles->last()->id}");
    }

    public function test_generate_one_command_successful(): void
    {
        $this->artisan('pdfs:generate-one', [
            'model' => DigitalPublicationArticle::class,
            'id' => $this->articles->first()->id,
        ])
            ->assertSuccessful()
            ->expectsOutput("Generated PDF for DigitalPublicationArticle with ID {$this->articles->first()->id}");
    }

    public function test_pdf_download_path_updated(): void
    {
        $this->assertNull($this->articles->first()->pdf_download_path);
        $this->artisan('pdfs:generate-one', [
            'model' => DigitalPublicationArticle::class,
            'id' => $this->articles->first()->id,
        ]);
        $this->articles->first()->refresh();
        $downloadPath = GeneratePdfs::downloadPath(GeneratePdfs::fileName($this->articles->first()));
        $this->assertEquals($downloadPath, $this->articles->first()->pdf_download_path);
    }

    public function test_pdf_uploaded(): void
    {
        Config::set('aic.pdf_s3_enabled', true);
        Storage::fake('pdf_s3');
        $this->artisan('pdfs:generate-one', [
            'model' => DigitalPublicationArticle::class,
            'id' => $this->articles->first()->id,
        ]);
        $fileName = GeneratePdfs::fileName($this->articles->first());
        $localPath = GeneratePdfs::localPath($fileName);
        Storage::disk('local')->assertMissing($localPath);
        $downloadPath = GeneratePdfs::downloadPath($fileName);
        Storage::disk('pdf_s3')->assertExists($downloadPath);
    }
}
