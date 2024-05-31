<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationSection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class PrinceTest extends BaseTestCase
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
    }

    public function test_errors_when_prince_binary_not_present(): void
    {
        Http::fake();
        $noPrinceCommand = '/dev/null';
        Config::set('aic.prince_command', $noPrinceCommand);
        $this->artisan('pdfs:generate')->assertFailed()->expectsOutput("Prince could not be found at $noPrinceCommand");
    }

    public function test_errors_when_prince_cannot_generate_pdf(): void
    {
        Http::fake(['*' => Http::response('<link rel="stylesheet" href="missing resource">')]);
        $id = $this->sections->first()->id;
        $this->artisan('pdfs:generate-one', [
            'model' => DigitalPublicationSection::class,
            'id' => $id,
        ])
            ->assertFailed()
            ->expectsOutput("Prince was unable to generate a PDF for DigitalPublicationSection with ID {$id}");
    }
}
