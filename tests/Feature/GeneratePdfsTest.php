<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Console\Commands\GeneratePdfs;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationSection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GeneratePdfsTest extends BaseTestCase
{
    protected Collection $sections;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sections = DigitalPublicationSection::factory()
            ->count(2)
            ->published()
            ->for(DigitalPublication::factory()->published())
            ->create();
        Http::fake();
    }

    public function test_generate_command_successful()
    {
        $this->artisan('pdfs:generate')
            ->assertSuccessful()
            ->expectsOutput("Generated PDF for DigitalPublicationSection with ID {$this->sections->first()->id}")
            ->expectsOutput("Generated PDF for DigitalPublicationSection with ID {$this->sections->last()->id}");
    }

    public function test_generate_one_command_successful()
    {
        $this->artisan('pdfs:generate-one', [
            'model' => DigitalPublicationSection::class,
            'id' => $this->sections->first()->id,
        ])
            ->assertSuccessful()
            ->expectsOutput("Generated PDF for DigitalPublicationSection with ID {$this->sections->first()->id}");
    }

    public function test_errors_when_prince_binary_not_present()
    {
        $noPrinceCommand = '/dev/null';
        Config::set('aic.prince_command', $noPrinceCommand);
        $this->artisan('pdfs:generate')->assertFailed()->expectsOutput("Prince could not be found at $noPrinceCommand");
    }

    public function test_pdf_download_path_updated()
    {
        $this->assertNull($this->sections->first()->pdf_download_path);
        $this->artisan('pdfs:generate-one', [
            'model' => DigitalPublicationSection::class,
            'id' => $this->sections->first()->id,
        ]);
        $this->sections->first()->refresh();
        $downloadPath = GeneratePdfs::pdfDownloadPath(GeneratePdfs::pdfFileName($this->sections->first()));
        $this->assertEquals($downloadPath, $this->sections->first()->pdf_download_path);
    }

    public function test_pdf_uploaded()
    {
        Config::set('aic.pdf_s3_enabled', true);
        Storage::fake('pdf_s3');
        $this->artisan('pdfs:generate-one', [
            'model' => DigitalPublicationSection::class,
            'id' => $this->sections->first()->id,
        ]);
        $downloadPath = GeneratePdfs::pdfDownloadPath(GeneratePdfs::pdfFileName($this->sections->first()));
        Storage::disk('pdf_s3')->assertExists($downloadPath);
    }
}
