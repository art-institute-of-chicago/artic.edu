<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\EventProgram;

class EventProgramTest extends BaseTestCase
{
    public function test_event_programs_exist()
    {
        // XXX I'm not sure how useful of a test this is.
        $this->assertDatabaseCount('event_programs', 31);
    }
}
