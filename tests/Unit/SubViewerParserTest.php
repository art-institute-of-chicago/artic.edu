<?php

namespace Tests\Unit;

use App\Libraries\Caption\Parser as CaptionParser;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class SubViewerParserTest extends BaseTestCase
{
    public $parser;

    public function setUp(): void
    {
        $this->parser = CaptionParser::parseFile(self::FILE);
    }

    public function test_captions_are_parsed_from_file_contents(): void
    {
        $captions = $this->parser->captions;
        $this->assertCount(6, $captions, 'The correct amount of captions were parsed');
        foreach ($captions as $caption) {
            $this->assertObjectHasProperty('start', $caption);
            $this->assertObjectHasProperty('end', $caption);
            $this->assertObjectHasProperty('lines', $caption);
        }
    }

    public function test_transcript_is_generated_from_captions(): void
    {
        $transcript = $this->parser->getTranscript();
        $this->assertIsString($transcript);
        $this->assertStringStartsWith(
            '(audience applauding)',
            $transcript,
            'The transcript starts with the correct line',
        );
        $this->assertStringEndsWith(
            'Thank you all for joining us this evening.',
            $transcript,
            'The transcript ends with the correct line'
        );
    }

    public function test_dashes_at_begining_of_lines_are_transcribed_as_newlines(): void
    {
        $captions = $this->parser->captions;
        $secondCaptionFirstLine = $captions[1]->lines[0];
        $this->assertStringContainsString(
            '- Good evening, everybody.',
            $secondCaptionFirstLine,
            'A `- ` at the beginning of a line denotes a newline',
        );
        $transcript = $this->parser->getTranscript();
        $this->assertStringContainsString(
            "\nGood evening, everybody.",
            $transcript,
            'The transcript contains `- ` replaced with a newline',
        );
    }

    private const FILE = <<<'FILE'
        0:00:00.246,0:00:03.413
        (audience applauding)

        0:00:05.370,0:00:06.810
        - Good evening, everybody.

        0:00:06.810,0:00:08.310
        I'm going to assume that applause was

        0:00:08.310,0:00:10.530
        for Jeremy Frey and not for me,

        0:00:10.530,0:00:11.880
        but that's totally fine.
        (audience laughing)

        0:00:11.880,0:00:14.820
        Thank you all for joining us this evening.
        FILE;
}
