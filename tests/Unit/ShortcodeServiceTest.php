<?php

namespace Tests\Unit;

use App\Libraries\ShortcodeService;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class ShortcodeServiceTest extends BaseTestCase
{
    // Implementing: https://regex101.com/r/5dOPYU/1
    public function test_REF_REGEXP(): void
    {
        $shortcodedHtml = <<<'HTML'
            <p>Let&#8217;s give him a friend too.[ref]FPO Franklin Rosemont, “Manifesto on the Position and Direction of the Surrealist Movement in the United States,” in&nbsp;<em>Arsenal: Surrealist Subversion</em>, vol. 1, edited by Franklin Rosemont (Chicago: Black Swan Press: 1970), 13.[/ref] Everybody needs a friend. From all of us here, I want to wish you happy painting and God bless, my friends. Everybody&#8217;s different. Trees are different.[ref]FPO Sometimes titled&nbsp;<em>The Secret Voyage (with portrait of Dori and Pancho) (A viagem secreta [com retrato de Dori e Pancho])</em>, my co-curators and I saw this painting in Guedes’s home in Sintra, Portugal. It was not included in&nbsp;<em>Malangatana: Mozambique Modern</em>&nbsp;due to the conservation that would have been required.[/ref] Let them all be individuals.</p><p>That&#8217;s a son of a gun of a cloud. There comes a nice little fluffer. I get carried away with this brush cleaning.</p>
        HTML;
        $matches = array();
        preg_match_all(ShortcodeService::REF_REGEXP, $shortcodedHtml, $matches, PREG_SET_ORDER);


        $this->assertRefRegexpMatches(
            [
                0 => "[ref]FPO Franklin Rosemont, “Manifesto on the Position and Direction of the Surrealist Movement in the United States,” in&nbsp;<em>Arsenal: Surrealist Subversion</em>, vol. 1, edited by Franklin Rosemont (Chicago: Black Swan Press: 1970), 13.[/ref]",
                1 => "[ref]FPO Franklin Rosemont, “Manifesto on the Position and Direction of the Surrealist Movement in the United States,” in&nbsp;<em>Arsenal: Surrealist Subversion</em>, vol. 1, edited by Franklin Rosemont (Chicago: Black Swan Press: 1970), 13.[/ref]",
                2 => "ref",
                3 => "FPO Franklin Rosemont, “Manifesto on the Position and Direction of the Surrealist Movement in the United States,” in&nbsp;<em>Arsenal: Surrealist Subversion</em>, vol. 1, edited by Franklin Rosemont (Chicago: Black Swan Press: 1970), 13.",
            ],
            $matches[0],
        );

        $this->assertRefRegexpMatches(
            [
                0 => "[ref]FPO Sometimes titled&nbsp;<em>The Secret Voyage (with portrait of Dori and Pancho) (A viagem secreta [com retrato de Dori e Pancho])</em>, my co-curators and I saw this painting in Guedes’s home in Sintra, Portugal. It was not included in&nbsp;<em>Malangatana: Mozambique Modern</em>&nbsp;due to the conservation that would have been required.[/ref]",
                1 => "[ref]FPO Sometimes titled&nbsp;<em>The Secret Voyage (with portrait of Dori and Pancho) (A viagem secreta [com retrato de Dori e Pancho])</em>, my co-curators and I saw this painting in Guedes’s home in Sintra, Portugal. It was not included in&nbsp;<em>Malangatana: Mozambique Modern</em>&nbsp;due to the conservation that would have been required.[/ref]",
                2 => "ref",
                3 => "FPO Sometimes titled&nbsp;<em>The Secret Voyage (with portrait of Dori and Pancho) (A viagem secreta [com retrato de Dori e Pancho])</em>, my co-curators and I saw this painting in Guedes’s home in Sintra, Portugal. It was not included in&nbsp;<em>Malangatana: Mozambique Modern</em>&nbsp;due to the conservation that would have been required.",
            ],
            $matches[1],
        );
    }

    public function assertRefRegexpMatches(array $expected, array $matches): void
    {
        foreach (array_keys($expected) as $index) {
            $this->assertArrayHasKey($index, $matches, "Match $index exists");
            $this->assertRefRegexpMatchHasGroups($matches);
        }

        $this->assertEquals(
            $expected[0],
            $matches['shortcode'],
            'The full match is the shortcode',
        );

        $this->assertEquals(
            $expected[1],
            $matches['shortcode'],
            'The first capture group is a [ref]...[/ref] tag',
        );

        $this->assertEquals(
            $expected[2],
            $matches['name'],
            'The second capture group is the name of the [ref] tag',
        );

        $this->assertEquals(
            $matches[3],
            $matches['content'],
            'The third capture group is the content inside the tag',
        );
    }

    public function assertRefRegexpMatchHasGroups(array $match): void
    {
        foreach (['shortcode', 'name', 'content'] as $group) {
            $this->assertArrayHasKey($group, $match, "Match group $group exists");
        }
    }
}
