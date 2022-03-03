<?php

namespace Tests\Unit;

use Tests\TestCase;

use Carbon\Carbon;

use App\Models\Issue;
use App\Models\IssueArticle;

class IssueArticleTest extends TestCase
{

    /** @test */
    public function it_doesnt_publish_if_issue_isnt_published()
    {
        $issue = Issue::factory()->create([
            'published' => false,
            'title' => 'Unpublished test',
        ]);

        $issueArticle = IssueArticle::factory()->create([
            'publish_start_date' => Carbon::yesterday(),
            'title' => 'Published test',
            'issue_id' => $issue->id,
        ]);

        $this->assertFalse($issueArticle->published);

        $issue->delete();
        $issueArticle->delete();
    }
}
