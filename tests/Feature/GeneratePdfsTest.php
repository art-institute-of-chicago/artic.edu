<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Console\Commands\GeneratePdfs;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationSection;
use App\Models\Issue;
use App\Models\IssueArticle;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GeneratePdfsTest extends BaseTestCase
{
    protected DigitalPublicationSection $section;
    protected IssueArticle $article;

    protected function setUp(): void
    {
        parent::setUp();
        $this->article = IssueArticle::factory()
            ->published()
            ->for(Issue::factory()->published())
            ->create();
        $this->section = DigitalPublicationSection::factory()
            ->published()
            ->for(DigitalPublication::factory()->published())
            ->create();
        Http::fake();
    }

    public function test_generate_command_successful()
    {
        $this->artisan('pdfs:generate')
            ->assertSuccessful()
            ->expectsOutput("Generated PDF for IssueArticle with ID {$this->article->id}")
            ->expectsOutput("Generated PDF for DigitalPublicationSection with ID {$this->section->id}");
    }

    public function test_generate_one_command_successful()
    {
        $this->artisan('pdfs:generate-one', ['model' => IssueArticle::class, 'id' => $this->article->id])
            ->assertSuccessful()
            ->expectsOutput("Generated PDF for IssueArticle with ID {$this->article->id}");
    }

    public function test_errors_when_prince_binary_not_present()
    {
        $noPrinceCommand = '/dev/null';
        Config::set('aic.prince_command', $noPrinceCommand);
        $this->artisan('pdfs:generate')->assertFailed()->expectsOutput("Prince could not be found at $noPrinceCommand");
    }

    public function test_pdf_download_path_updated()
    {
        $this->assertNull($this->article->pdf_download_path);
        $this->artisan('pdfs:generate-one', ['model' => IssueArticle::class, 'id' => $this->article->id]);
        $this->article->refresh();
        $downloadPath = GeneratePdfs::pdfDownloadPath(GeneratePdfs::pdfFileName($this->article));
        $this->assertEquals($downloadPath, $this->article->pdf_download_path);
    }

    public function test_pdf_uploaded()
    {
        Config::set('aic.pdf_s3_enabled', true);
        Storage::fake('pdf_s3');
        $this->artisan('pdfs:generate-one', ['model' => IssueArticle::class, 'id' => $this->article->id]);
        $downloadPath = GeneratePdfs::pdfDownloadPath(GeneratePdfs::pdfFileName($this->article));
        Storage::disk('pdf_s3')->assertExists($downloadPath);
    }
}
