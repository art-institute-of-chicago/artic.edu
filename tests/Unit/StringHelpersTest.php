<?php

namespace Tests\Unit;

use App\Helpers\StringHelpers;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class StringHelpersTest extends BaseTestCase
{
    #[DataProvider('htmlEntities')]
    public function test_getLastWord_finds_last_html_entity(string $htmlEntity): void
    {
        [$beforeLastWord, $lastWord] = StringHelpers::getLastWord('Text before HTML entity ' . $htmlEntity . ' ');
        $this->assertEquals('Text before HTML entity ', $beforeLastWord);
        $this->assertEquals($htmlEntity, $lastWord);
    }

    public function test_getLastWord_finds_last_tag(): void
    {
        [$beforeLastWord, $lastWord] = StringHelpers::getLastWord('Text not in a tag <em>Text in ending tag</em> ');
        $this->assertEquals('Text not in a tag ', $beforeLastWord);
        $this->assertEquals('<em>Text in ending tag</em>', $lastWord);
    }

    public function test_getLastWord_finds_last_tag_with_attributes(): void
    {
        [$beforeLastWord, $lastWord] = StringHelpers::getLastWord('Text not in a link <a id="id" href="/path">Text in a link</a>');
        $this->assertEquals('Text not in a link ', $beforeLastWord);
        $this->assertEquals('<a id="id" href="/path">Text in a link</a>', $lastWord);
    }

    public function test_getLastWord_finds_non_html_non_space_character(): void
    {
        [$beforeLastWord, $lastWord] = StringHelpers::getLastWord('Text ending with a non-html, non-space character. ');
        $this->assertEquals('Text ending with a non-html, non-space character', $beforeLastWord);
        $this->assertEquals('.', $lastWord);
    }

    public static function htmlEntities(): array
    {
        return array_map(
            fn ($htmlEntity) => [$htmlEntity],
            get_html_translation_table(HTML_ENTITIES),
        );
    }
}
