<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Carbon\Carbon;

use App\Models\Issue;
use App\Models\IssueArticle;
use Tests\CreatesApplication;

class IssueArticleTest extends BaseTestCase
{
    use CreatesApplication;

    /** @test */
    public function it_doesnt_publish_if_issue_isnt_published()
    {
        $issue = Issue::factory()->make([
            'published' => false,
            'title' => 'Unpublished test',
        ]);

        $issueArticle = IssueArticle::factory()->make([
            'publish_start_date' => Carbon::yesterday(),
            'title' => 'Published test',
            'issue_id' => $issue->id,
        ]);

        $this->assertFalse($issueArticle->published);

        $issue->delete();
        $issueArticle->delete();
    }
}
