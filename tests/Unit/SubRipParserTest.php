<?php

namespace Tests\Unit;

use App\Libraries\Caption\Parser as CaptionParser;
use App\Models\Video;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class SubRipParserTest extends BaseTestCase
{
    public $parser;

    public function setUp(): void
    {
        $this->parser = CaptionParser::parseFile(self::FILE);
    }

    public function test_captions_are_parsed_from_file_contents(): void
    {
        $captions = $this->parser->captions;
        $this->assertCount(5, $captions, 'The correct amount of captions were parsed');
        foreach ($captions as $caption) {
            $this->assertObjectHasProperty('index', $caption);
            $this->assertObjectHasProperty('start', $caption);
            $this->assertObjectHasProperty('end', $caption);
            $this->assertObjectHasProperty('lines', $caption);
        }
    }

    public function test_transcript_is_generated_from_captions(): void
    {
        $transcript = $this->parser->getTranscript(Video::factory()->make());
        $this->assertIsString($transcript);
        $this->assertStringContainsString(
            '(people chattering)',
            $transcript,
            'The transcript contains the starting line',
        );
        $this->assertStringContainsString(
            'Art Institute of Chicago.',
            $transcript,
            'The transcript contains the ending line',
        );
    }

    public function test_dashes_at_begining_of_lines_are_transcribed_as_newlines(): void
    {
        $captions = $this->parser->captions;
        $secondCaptionFirstLine = $captions[1]->lines[0];
        $this->assertStringContainsString(
            '- Good evening, and welcome.',
            $secondCaptionFirstLine,
            'A `- ` at the beginning of a line denotes a newline',
        );
        $transcript = $this->parser->getTranscript(Video::factory()->make());
        $this->assertMatchesRegularExpression(
            '/<p>\s*Good evening, and welcome\./',
            $transcript,
            'The transcript contains `- ` replaced with a paragraph tag',
        );
    }

    private const FILE = <<<'FILE'
        1
        00:00:00,472 --> 00:00:03,472
        (people chattering)

        2
        00:00:05,280 --> 00:00:07,020
        - Good evening, and welcome.

        3
        00:00:07,020 --> 00:00:10,470
        I'm Lisa Ayla Cakmak, the
        Mary and Michael Jaharis Chair

        4
        00:00:10,470 --> 00:00:12,780
        and Curator of Arts of Greece, Rome,

        5
        00:00:12,780 --> 00:00:16,093
        and Byzantium here at the
        Art Institute of Chicago.
        FILE;
}
