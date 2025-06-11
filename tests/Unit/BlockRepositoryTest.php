<?php

namespace Tests\Unit;

use App\Repositories\BlockRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class BlockRepositoryTest extends BaseTestCase
{
    protected $blockRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->blockRepository = app(BlockRepository::class);
    }

    public function test_it_trims_whitespace(): void
    {
        $result = $this->blockRepository->cleanNonSubstantialContent('   ');
        $this->assertEmpty($result);

        $result = $this->blockRepository->cleanNonSubstantialContent('   Not removed   ');
        $this->assertEquals('Not removed', $result);
    }

    public function test_it_removes_paragraphs_with_only_whitespace(): void
    {
        $result = $this->blockRepository->cleanNonSubstantialContent('<p> </p>');
        $this->assertEmpty($result);

        $result = $this->blockRepository->cleanNonSubstantialContent("<p>\n</p>");
        $this->assertEmpty($result);
    }

    public function test_it_removes_paragraphs_with_only_breaks(): void
    {
        $result = $this->blockRepository->cleanNonSubstantialContent('<p><br /></p>');
        $this->assertEmpty($result);

        $result = $this->blockRepository->cleanNonSubstantialContent('<p><br></p>');
        $this->assertEmpty($result);

        $result = $this->blockRepository->cleanNonSubstantialContent('<p><br class="softbreak" /></p>');
        $this->assertEmpty($result);

        $result = $this->blockRepository->cleanNonSubstantialContent("<p><br class='softbreak'></p>");
        $this->assertEmpty($result);
    }

    public function test_it_returns_an_empty_string_if_there_is_no_substantial_content(): void
    {
        $result = $this->blockRepository->cleanNonSubstantialContent('<p><div><b><em>   </em></b></div></p>');
        $this->assertEmpty($result);
    }

    public function test_it_does_not_remove_paragraphs_with_substantial_content(): void
    {
        $result = $this->blockRepository->cleanNonSubstantialContent("<p>\n</p><p>Not removed</p><p><br /></p>");
        $this->assertEquals('<p>Not removed</p>', $result);

        $result = $this->blockRepository->cleanNonSubstantialContent('<p>Not<br class="softbreak">removed</p>');
        $this->assertEquals('<p>Not<br class="softbreak">removed</p>', $result);
    }
}
