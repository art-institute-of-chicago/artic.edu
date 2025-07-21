<?php

namespace Tests\Feature;

use App\Models\ResourceCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;

class EducatorResourceIndexTest extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_correctly_builds_the_meta_title_from_url_parameters(): void
    {
        $queryParams = [
            'content' => 'artwork-spotlight',
            'audience' => 'elementary',
            'topic' => 'aaapi-art',
            'filter' => 'all',
            'page' => '1',
            'locale' => 'es',
        ];

        $response = $this->get(route('collection.resources.educator-resources', $queryParams));
        $response->assertOk();
        $content = $response->getContent();

        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $this->assertCount(2, $matches, 'no title tag');

        $actualTitle = $matches[1];

        $this->assertStringContainsString('Educator Resources', $actualTitle);
        $this->assertStringContainsString('Artwork Spotlight', $actualTitle);
        $this->assertStringContainsString('Elementary', $actualTitle);
        $this->assertStringContainsString('Aaapi Art', $actualTitle);
        $this->assertStringContainsString('Español', $actualTitle);
        $this->assertStringContainsString('| The Art Institute of Chicago', $actualTitle);
    }

    public function test_it_builds_the_title_by_omitting_irrelevant_parameters(): void
    {
        $queryParams = [
            'content' => 'all',
            'audience' => 'high-school',
            'topic' => '',
        ];

        ResourceCategory::factory()->create(['type' => 'audience', 'name' => 'High School']);

        $response = $this->get(route('collection.resources.educator-resources', $queryParams));
        $response->assertOk();
        $content = $response->getContent();

        preg_match('/<title>(.*?)<\/title>/', $content, $matches);
        $this->assertCount(2, $matches, 'no title tag');

        $actualTitle = $matches[1];

        $this->assertStringContainsString('Educator Resources', $actualTitle);
        $this->assertStringContainsString('High School', $actualTitle);
        $this->assertStringContainsString('| The Art Institute of Chicago', $actualTitle);
        $this->assertStringNotContainsString('all', $actualTitle);
        $this->assertStringNotContainsString('topic', $actualTitle);
    }

    public function test_it_shows_the_default_title_with_no_parameters(): void
    {
        $expectedTitle = 'Educator Resources | The Art Institute of Chicago';

        $response = $this->get(route('collection.resources.educator-resources'));
        $response->assertOk();
        $response->assertSee('<title>' . e($expectedTitle) . '</title>', false);
    }
}
