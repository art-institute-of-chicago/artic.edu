<?php

namespace Tests\Unit;

use App\Libraries\ShortcodeService;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class ShortcodeServiceTest extends BaseTestCase
{
    public function test_parse_ref(): void
    {
        [$parsedRef] = ShortcodeService::parse_ref('<p>[ref]text[/ref]</p>');
        $this->assertArrayHasKey('shortcode', $parsedRef, 'The shortcode is a [tag]...[/tag] with content');
        $this->assertArrayHasKey('name', $parsedRef, 'The tag has a name');
        $this->assertArrayHasKey('content', $parsedRef, 'There is content inside the tag');
    }

    // Implementing: https://regex101.com/r/5dOPYU/1
    public function test_parse_ref_with_multiple_tags(): void
    {
        $htmlWithRefs = <<<'HTML'
            <p>Let&#8217;s give him a friend too.[ref]FPO Franklin Rosemont, “Manifesto on the Position and Direction of the Surrealist Movement in the United States,” in&nbsp;<em>Arsenal: Surrealist Subversion</em>, vol. 1, edited by Franklin Rosemont (Chicago: Black Swan Press: 1970), 13.[/ref] Everybody needs a friend. From all of us here, I want to wish you happy painting and God bless, my friends. Everybody&#8217;s different. Trees are different.[ref]FPO Sometimes titled&nbsp;<em>The Secret Voyage (with portrait of Dori and Pancho) (A viagem secreta [com retrato de Dori e Pancho])</em>, my co-curators and I saw this painting in Guedes’s home in Sintra, Portugal. It was not included in&nbsp;<em>Malangatana: Mozambique Modern</em>&nbsp;due to the conservation that would have been required.[/ref] Let them all be individuals.</p><p>That&#8217;s a son of a gun of a cloud. There comes a nice little fluffer. I get carried away with this brush cleaning.</p>
        HTML;

        $parsedRefs = ShortcodeService::parse_ref($htmlWithRefs);
        $this->assertCount(2, $parsedRefs);

        [$firstRef, $secondRef] = $parsedRefs;
        $this->assertEquals(
            '[ref]FPO Franklin Rosemont, “Manifesto on the Position and Direction of the Surrealist Movement in the United States,” in&nbsp;<em>Arsenal: Surrealist Subversion</em>, vol. 1, edited by Franklin Rosemont (Chicago: Black Swan Press: 1970), 13.[/ref]',
            $firstRef['shortcode'],
        );
        $this->assertEquals(
            'ref',
            $firstRef['name'],
        );
        $this->assertEquals(
            'FPO Franklin Rosemont, “Manifesto on the Position and Direction of the Surrealist Movement in the United States,” in&nbsp;<em>Arsenal: Surrealist Subversion</em>, vol. 1, edited by Franklin Rosemont (Chicago: Black Swan Press: 1970), 13.',
            $firstRef['content'],
        );
        $this->assertEquals(
            '[ref]FPO Sometimes titled&nbsp;<em>The Secret Voyage (with portrait of Dori and Pancho) (A viagem secreta [com retrato de Dori e Pancho])</em>, my co-curators and I saw this painting in Guedes’s home in Sintra, Portugal. It was not included in&nbsp;<em>Malangatana: Mozambique Modern</em>&nbsp;due to the conservation that would have been required.[/ref]',
            $secondRef['shortcode'],
        );
        $this->assertEquals(
            'ref',
            $secondRef['name'],
        );
        $this->assertEquals(
            'FPO Sometimes titled&nbsp;<em>The Secret Voyage (with portrait of Dori and Pancho) (A viagem secreta [com retrato de Dori e Pancho])</em>, my co-curators and I saw this painting in Guedes’s home in Sintra, Portugal. It was not included in&nbsp;<em>Malangatana: Mozambique Modern</em>&nbsp;due to the conservation that would have been required.',
            $secondRef['content'],
        );
    }
}
