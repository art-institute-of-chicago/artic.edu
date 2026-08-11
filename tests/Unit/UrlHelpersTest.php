<?php

namespace Tests\Unit;

use App\Helpers\UrlHelpers;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class UrlHelpersTest extends BaseTestCase
{
    #[DataProvider('videoUrls')]
    public function test_parseVideoUrl_extracts_id_and_hash(string $url, string|int $expected): void
    {
        $this->assertSame($expected, UrlHelpers::parseVideoUrl($url));
    }

    public static function videoUrls(): array
    {
        return [
            // Plain public video URLs
            'plain url' => ['https://vimeo.com/123456789', '123456789'],
            'plain url with share params' => ['https://vimeo.com/1214680519?share=copy&fl=sv&fe=ci', '1214680519'],
            'player url' => ['https://player.vimeo.com/video/123456789', '123456789'],

            // Unlisted videos: privacy hash must be preserved as ?h=
            'unlisted with hash path' => ['https://vimeo.com/1217430890/681018b37e', '1217430890?h=681018b37e'],
            'unlisted with hash path and share params' => ['https://vimeo.com/1217430890/681018b37e?share=copy&fl=sv&fe=ci', '1217430890?h=681018b37e'],
            'player url with hash path' => ['https://player.vimeo.com/video/1217430890/681018b37e', '1217430890?h=681018b37e'],
            'player url with h param' => ['https://player.vimeo.com/video/1217430890?h=681018b37e', '1217430890?h=681018b37e'],

            // Review links: hash after the ID is the embeddable privacy hash
            'review link' => ['https://vimeo.com/artinstitute/review/389118355/0d5419b574', '389118355?h=0d5419b574'],

            // Channel/group style paths: non-numeric segments are skipped
            'channel url' => ['https://vimeo.com/channels/staffpicks/123456', '123456'],

            // Invalid input
            'empty string' => ['', 0],
            'no vimeo url' => ['https://example.com/foo', 0],
            'no digits' => ['https://vimeo.com/about', 0],
        ];
    }
}
