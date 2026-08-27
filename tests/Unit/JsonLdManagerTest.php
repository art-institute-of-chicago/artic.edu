<?php

namespace Tests\Unit;

use App\Libraries\SchemaOrg\JsonLdManager;
use App\Libraries\SchemaOrg\SchemaMapper;
use App\Models\Api\Artist;
use App\Models\Api\Artwork;
use App\Models\Api\Department;
use App\Models\Api\Exhibition;
use App\Models\Api\Gallery;
use App\Models\Article;
use App\Models\Author;
use App\Models\DigitalExplorer;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationArticle;
use App\Models\EducatorResource;
use App\Models\Event;
use App\Models\Experience;
use App\Models\GenericPage;
use App\Models\Highlight;
use App\Models\LandingPage;
use App\Models\MagazineIssue;
use App\Models\MyMuseumTour;
use App\Models\Playlist;
use App\Models\DateRule;
use App\Models\PrintedPublication;
use App\Models\Video;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class JsonLdManagerTest extends BaseTestCase
{
    // Factory policy: every fixture is built through a database factory with
    // ->make() (never ->create()), so nothing is persisted and the suite
    // stays DB-free on the host. Eloquent models are built with
    // Model::factory()->withoutParents()->make(); Twill models get their
    // slugs relation primed via withSlug() so getSlug()/URL generation never
    // queries the database, and Author's hero media is primed via withMedia()
    // so imageFront() resolves without one. The App\Models\Api\* pseudo-models
    // (Artwork, Artist, Exhibition, Gallery, Department) are built with the
    // Database\Factories\Api\* factories; because those models default to
    // $augmented = true (any null attribute read falls through to a database
    // lookup of the augmented Eloquent model), apiModel() disables that
    // fallback via reflection so the fixtures stay DB-free. Event is the one
    // model whose date_start/date_end accessors always resolve from the
    // event_metas relation (a database query), so eventFixture() wraps the
    // factory-built record in an anonymous subclass that supplies the dates
    // from a preloaded collection instead.

    /**
     * Prime the Twill slugs relation so getSlug() resolves without a database.
     * Factory-built make() records are not persisted, so URL generation needs
     * the relation preloaded to stay DB-free. $slugClass is the model's Twill
     * slug class (e.g. App\Models\Slugs\ArticleSlug).
     */
    protected function withSlug(\Illuminate\Database\Eloquent\Model $model, string $slug, string $slugClass): \Illuminate\Database\Eloquent\Model
    {
        $slugModel = new $slugClass();
        $slugModel->slug = $slug;
        $slugModel->active = true;
        $slugModel->locale = app()->getLocale();

        $model->setRelation('slugs', collect([$slugModel]));

        return $model;
    }

    /**
     * Prime the Twill medias relation so HasMediasEloquent::imageFront()
     * resolves the hero image without a database query. The media carries a
     * pivot (role/crop + crop coordinates) and an empty tags relation, which
     * is all convertImageFront() reads off the record.
     */
    protected function withMedia(\Illuminate\Database\Eloquent\Model $model, string $uuid): \Illuminate\Database\Eloquent\Model
    {
        $media = new \A17\Twill\Models\Media([
            'uuid' => $uuid,
            'filename' => $uuid . '.jpg',
            'width' => 3000,
            'height' => 3000,
        ]);
        $media->setRelation('pivot', (object) [
            'role' => 'hero',
            'crop' => 'default',
            'crop_x' => 0,
            'crop_y' => 0,
            'crop_w' => 0,
            'crop_h' => 0,
        ]);
        $media->setRelation('tags', collect());

        $model->setRelation('medias', collect([$media]));

        return $model;
    }

    /**
     * Disable the augmented-model fallback on factory-built API pseudo-models
     * so null attribute reads never fall through to a database query.
     */
    protected function apiModel(mixed $model): mixed
    {
        $augmented = new \ReflectionProperty($model, 'augmented');
        $augmented->setValue($model, false);

        return $model;
    }

    /**
     * The controller whose jsonLdDefinition() supplies the schema.org
     * definition for each model class under test, keyed by real model class
     * (App\Models\Api\Artwork -> ArtworkController, etc.).
     *
     * @var array<class-string, class-string>
     */
    private const DEFINITION_CONTROLLERS = [
        Article::class => \App\Http\Controllers\ArticleController::class,
        DigitalExplorer::class => \App\Http\Controllers\DigitalExplorerController::class,
        DigitalPublication::class => \App\Http\Controllers\DigitalPublicationsController::class,
        DigitalPublicationArticle::class => \App\Http\Controllers\DigitalPublicationArticleController::class,
        Experience::class => \App\Http\Controllers\InteractiveFeatureExperiencesController::class,
        GenericPage::class => \App\Http\Controllers\GenericPagesController::class,
        LandingPage::class => \App\Http\Controllers\LandingPagesController::class,
        Playlist::class => \App\Http\Controllers\PlaylistController::class,
        Video::class => \App\Http\Controllers\VideoController::class,
        Artwork::class => \App\Http\Controllers\ArtworkController::class,
        Artist::class => \App\Http\Controllers\ArtistController::class,
        Author::class => \App\Http\Controllers\AuthorController::class,
        Department::class => \App\Http\Controllers\DepartmentController::class,
        EducatorResource::class => \App\Http\Controllers\EducatorResourcesController::class,
        Event::class => \App\Http\Controllers\EventsController::class,
        Exhibition::class => \App\Http\Controllers\ExhibitionsController::class,
        Gallery::class => \App\Http\Controllers\GalleryController::class,
        Highlight::class => \App\Http\Controllers\HighlightsController::class,
        MagazineIssue::class => \App\Http\Controllers\MagazineIssueController::class,
        MyMuseumTour::class => \App\Http\Controllers\MyMuseumTourController::class,
        PrintedPublication::class => \App\Http\Controllers\PrintedPublicationsController::class,
    ];

    /**
     * Obtain a controller's schema.org definition for the given model instead
     * of re-declaring it here. jsonLdDefinition() is protected, so it is
     * invoked via reflection on an instance created without its constructor
     * (the method only composes definition arrays and never touches
     * controller state, constructor dependencies, or the database).
     *
     * @return array<string, mixed>
     */
    private function definitionFor(mixed $model, ?string $controllerClass = null): array
    {
        // Anonymous subclasses (the DB-free Event fixture) resolve to the
        // parent model class for the controller lookup.
        $controllerClass ??= self::DEFINITION_CONTROLLERS[get_class($model)]
            ?? self::DEFINITION_CONTROLLERS[get_parent_class($model)]
            ?? null;

        if ($controllerClass === null) {
            $this->fail('No controller mapped for model ' . get_class($model));
        }

        $controller = (new \ReflectionClass($controllerClass))->newInstanceWithoutConstructor();

        return (new \ReflectionMethod($controllerClass, 'jsonLdDefinition'))->invoke($controller, $model);
    }

    public function test_mapper_for_returns_null_for_unmapped_models(): void
    {
        $manager = new JsonLdManager();

        $this->assertNull($manager->mapperFor(new \stdClass()));
    }

    public function test_add_model_entity_registers_entity(): void
    {
        $manager = new JsonLdManager();

        $artwork = $this->artworkFixture();

        $manager->addModelEntity($artwork, $this->definitionFor($artwork));

        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'VisualArtwork');

        $this->assertNotNull($entity);
        $this->assertSame('Starry Night', $entity['name']);
    }

    public function test_add_model_entity_registers_entity_and_returns_nothing(): void
    {
        $manager = new JsonLdManager();

        $artwork = $this->artworkFixture();

        $this->assertNull($manager->addModelEntity($artwork, $this->definitionFor($artwork)));

        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'VisualArtwork');

        $this->assertNotNull($entity);
        $this->assertSame('Starry Night', $entity['name']);
    }

    public function test_add_model_entity_skips_models_without_a_definition(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new \stdClass());

        $this->assertCount(2, $this->extractGraph($manager->renderGraphScript()));
    }

    public function test_add_model_entity_skips_an_empty_definition(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new \stdClass(), []);

        $this->assertCount(2, $this->extractGraph($manager->renderGraphScript()));
    }

    public function test_add_model_entity_collects_entities_together(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity($this->artworkFixture(), $this->definitionFor($this->artworkFixture()));
        $manager->addModelEntity($this->articleFixture(), $this->definitionFor($this->articleFixture()));

        $graph = $this->extractGraph($manager->renderGraphScript());

        $this->assertNotNull($this->findEntity($graph, 'VisualArtwork'));
        $this->assertNotNull($this->findEntity($graph, 'BlogPosting'));
        $this->assertCount(4, $graph);
    }

    public function test_render_graph_script_contains_global_entities(): void
    {
        $manager = new JsonLdManager();

        $graph = $this->extractGraph($manager->renderGraphScript());

        $organization = $this->findEntity($graph, 'Museum');
        $this->assertNotNull($organization);
        $this->assertSame(['Museum', 'Organization'], $organization['@type']);
        $this->assertSame('https://www.artic.edu/#organization', $organization['@id']);
        $this->assertSame('Art Institute of Chicago', $organization['name']);
        $this->assertSame('https://www.artic.edu', $organization['url']);
        $this->assertIsString($organization['logo']);
        $this->assertStringContainsString('aic-favicon.svg', $organization['logo']);
        $this->assertSame('111 S Michigan Ave', $organization['address']['streetAddress']);
        $this->assertSame('60603', $organization['address']['postalCode']);
        $this->assertCount(5, $organization['sameAs']);
        $this->assertSame('1879', $organization['foundingDate']);
        $this->assertSame('ContactPoint', $organization['contactPoint']['@type']);
        $this->assertSame('customer service', $organization['contactPoint']['contactType']);
        $this->assertSame('https://www.artic.edu/visit', $organization['contactPoint']['url']);

        $website = $this->findEntity($graph, 'WebSite');
        $this->assertNotNull($website);
        $this->assertSame('https://www.artic.edu/#website', $website['@id']);
        $this->assertSame('https://www.artic.edu', $website['url']);
        $this->assertSame('Art Institute of Chicago', $website['name']);
        $this->assertSame('SearchAction', $website['potentialAction']['@type']);
        $this->assertSame('https://www.artic.edu/search?q={search_term_string}', $website['potentialAction']['target']);
        $this->assertSame('required name=search_term_string', $website['potentialAction']['query-input']);
    }

    public function test_visual_artwork_mapper(): void
    {
        $manager = new JsonLdManager();

        $artwork = $this->artworkFixture();

        $manager->addModelEntity($artwork, $this->definitionFor($artwork));
        $script = $manager->renderGraphScript();
        $entity = $this->findEntity($this->extractGraph($script), 'VisualArtwork');

        $this->assertNotNull($entity);
        $this->assertStringContainsString('"@type":"VisualArtwork"', $script);
        $this->assertStringContainsString('"name":"Starry Night"', $script);
        $this->assertStringContainsString('"description":"A starry night scene."', $script);
        $this->assertStringContainsString('"identifier":{"@type":"PropertyValue","propertyID":"main_reference_number","value":"1234"}', $script);
        $this->assertStringContainsString('"artist":[{"@type":"Person","name":"Vincent van Gogh"}]', $script);
        $this->assertStringContainsString('"width":{"@type":"QuantitativeValue","value":73.7,"unitCode":"CMT","unitText":"cm"}', $script);
        $this->assertStringContainsString('"height":{"@type":"QuantitativeValue","value":92.1,"unitCode":"CMT","unitText":"cm"}', $script);
        $this->assertStringContainsString('"copyrightNotice":"Public domain"', $script);
        $this->assertStringContainsString('"keywords":"Landscape, Post-Impressionism, Painting"', $script);
        $this->assertStringContainsString('"genre":"Painting"', $script);
        $this->assertStringContainsString('"isPartOf":{"@type":"Collection","name":"Arts of the Americas"}', $script);
        $this->assertStringContainsString('"displayLocation":"Gallery 100"', $script);
        $this->assertStringContainsString('"locationCreated":"France"', $script);
        $this->assertStringNotContainsString('contentLocation', $script);
        $this->assertStringContainsString('"encoding":{"@type":"DigitalDocument","@id":"https://api.artic.edu/api/v1/artworks/1/manifest.json","encodingFormat":"application/ld+json"}', $script);
        $this->assertStringContainsString('"sameAs":"https://api.artic.edu/api/v1/artworks/1"', $script);
        $this->assertStringContainsString('"inLanguage":"en"', $script);
        // Thumbnail URL derives from the IIIF image id provided by the factory
        $this->assertStringContainsString('/iiif/2/abc/full/!300,300/0/default.jpg', $script);
        $this->assertStringEndsWith('/artworks/1/starry-night', $entity['url']);
        $this->assertStringEndsWith('/artworks/1/starry-night', $entity['mainEntityOfPage']);
    }

    public function test_artwork_artist_emits_organization_for_culture(): void
    {
        $manager = new JsonLdManager();

        $artwork = $this->artworkFixture([
            'artists' => collect([
                (object) ['title' => 'Aztec (Mexica)', 'agent_type_title' => 'Culture', 'ulan_id' => '500115588'],
            ]),
        ]);

        $manager->addModelEntity($artwork, $this->definitionFor($artwork));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'VisualArtwork');

        $this->assertSame('Organization', $entity['artist'][0]['@type']);
        $this->assertSame('Aztec (Mexica)', $entity['artist'][0]['name']);
        $this->assertSame('https://vocab.getty.edu/ulan/500115588', $entity['artist'][0]['additionalType']);
    }

    public function test_artwork_artist_falls_back_to_aat_for_culture_without_ulan(): void
    {
        $manager = new JsonLdManager();

        $artwork = $this->artworkFixture([
            'artists' => collect([
                (object) ['title' => 'Unknown Yoruba artist', 'agent_type_title' => 'Culture'],
            ]),
        ]);

        $manager->addModelEntity($artwork, $this->definitionFor($artwork));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'VisualArtwork');

        $this->assertSame('Organization', $entity['artist'][0]['@type']);
        $this->assertSame('http://vocab.getty.edu/aat/300387177', $entity['artist'][0]['additionalType']);
    }

    public function test_exhibition_mapper(): void
    {
        $manager = new JsonLdManager();

        $exhibition = $this->exhibitionFixture();

        $manager->addModelEntity($exhibition, $this->definitionFor($exhibition));
        $script = $manager->renderGraphScript();
        $entity = $this->findEntity($this->extractGraph($script), 'ExhibitionEvent');

        $this->assertNotNull($entity);
        $this->assertStringContainsString('"@type":"ExhibitionEvent"', $script);
        $this->assertStringContainsString('"name":"Van Gogh and the Avant-Garde"', $script);
        $this->assertStringContainsString('"description":"An exhibition about Van Gogh."', $script);
        $this->assertStringContainsString('"startDate":"2024-05-01"', $script);
        $this->assertStringContainsString('"eventStatus":"https://schema.org/EventScheduled"', $script);
        $this->assertStringContainsString('"eventAttendanceMode":"https://schema.org/OfflineEventAttendanceMode"', $script);
        $this->assertStringContainsString('"inLanguage":"en"', $script);
        $this->assertStringContainsString('"location":{"@type":"Place","name":"Gallery 100","containedInPlace":{"@type":"Place","@id":"https://www.artic.edu/#organization","name":"Art Institute of Chicago","address":{"@type":"PostalAddress","streetAddress":"111 S Michigan Ave","addressLocality":"Chicago","addressRegion":"IL","postalCode":"60603","addressCountry":"US"}}}', $script);
        $this->assertStringNotContainsString('isAccessibleForFree', $script);
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $entity['organizer']);
        $this->assertStringEndsWith('/exhibitions/42/van-gogh-and-the-avant-garde', $entity['url']);
    }

    public function test_event_mapper(): void
    {
        $manager = new JsonLdManager();

        // Event::factory() cannot be used directly: Event's date_start /
        // date_end accessors always resolve from the event_metas relation,
        // which queries the database. eventFixture() builds the record via
        // the factory and wraps it in an anonymous subclass that supplies the
        // dates from a preloaded collection, keeping the fixture DB-free.
        $event = $this->eventFixture();

        $manager->addModelEntity($event, $this->definitionFor($event));
        $script = $manager->renderGraphScript();
        $entity = $this->findEntity($this->extractGraph($script), 'Event');

        $this->assertNotNull($entity);
        $this->assertStringContainsString('"@type":"Event"', $script);
        $this->assertStringContainsString('"duration":"PT3H"', $script);
        $this->assertStringContainsString('"location":{"@type":"Place","name":"Gallery 101","address":{"@type":"PostalAddress","streetAddress":"111 S Michigan Ave","addressLocality":"Chicago","addressRegion":"IL","postalCode":"60603","addressCountry":"US"}}', $script);
        $this->assertStringContainsString('"eventAttendanceMode":"https://schema.org/OfflineEventAttendanceMode"', $script);
        $this->assertStringContainsString('"isAccessibleForFree":true', $script);
        $this->assertStringContainsString('"audience":{"@type":"Audience","audienceType":"General Public"}', $script);
        $this->assertStringContainsString('"keywords":"Talk"', $script);
        $this->assertStringContainsString('"inLanguage":"en"', $script);
        $this->assertStringContainsString('"offers":{"@type":"Offer","url":"https://www.artic.edu/rsvp","availability":"https://schema.org/InStock","price":"0","priceCurrency":"USD"}', $script);
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $entity['organizer']);
        $this->assertStringEndsWith('/events/7/member-preview-night', $entity['url']);
    }

    public function test_event_mapper_omits_dates_and_emits_schedule_for_recurring_event(): void
    {
        $manager = new JsonLdManager();

        $event = $this->eventFixture();

        $rule = new DateRule();
        $rule->forceFill([
            'type' => 0,
            'every' => 1,
            'recurring_type' => 1,
            'start_date' => '2024-06-03',
            'end_date' => '2024-08-26',
            'monday' => true,
        ]);
        $event->setRelation('dateRules', collect([$rule]));

        $manager->addModelEntity($event, $this->definitionFor($event));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Event');

        $this->assertArrayNotHasKey('startDate', $entity);
        $this->assertArrayNotHasKey('endDate', $entity);
        $this->assertSame('Schedule', $entity['eventSchedule']['@type'] ?? null);
        $this->assertSame('P1W', $entity['eventSchedule']['repeatFrequency'] ?? null);
        $this->assertSame('MO', ($entity['eventSchedule']['byDay'][0] ?? null));
        $this->assertStringContainsString('2024-06-03', $entity['eventSchedule']['startDate'] ?? '');
    }

    public function test_virtual_event_mapper_uses_virtual_location_and_online_mode(): void
    {
        $manager = new JsonLdManager();

        $event = $this->eventFixture([
            'is_virtual_event' => true,
            'virtual_event_url' => 'https://zoom.us/j/123',
            'is_free' => false,
        ]);

        $manager->addModelEntity($event, $this->definitionFor($event));
        $script = $manager->renderGraphScript();

        $this->assertStringContainsString('"location":{"@type":"VirtualLocation","url":"https://zoom.us/j/123"}', $script);
        $this->assertStringContainsString('"eventAttendanceMode":"https://schema.org/OnlineEventAttendanceMode"', $script);
        $this->assertStringNotContainsString('isAccessibleForFree', $script);
    }

    public function test_article_mapper(): void
    {
        $manager = new JsonLdManager();

        $article = $this->articleFixture();

        $manager->addModelEntity($article, $this->definitionFor($article));
        $script = $manager->renderGraphScript();
        $articleEntity = $this->findEntity($this->extractGraph($script), 'BlogPosting');

        $this->assertNotNull($articleEntity);
        $this->assertStringContainsString('"@type":"BlogPosting"', $script);
        $this->assertStringContainsString('"headline":"' . $article->title . '"', $script);
        $this->assertStringContainsString('"description":"An introduction to the exhibition."', $script);
        $this->assertStringContainsString('"abstract":"Five things you need to know about the show."', $script);
        $this->assertStringContainsString('"keywords":"Art + Technology, Exhibitions"', $script);
        $this->assertStringContainsString('"inLanguage":"en"', $script);
        $this->assertStringContainsString('"author":[{"@type":"Person","name":"Jane Doe"},{"@type":"Person","name":"John Smith"}]', $script);
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $articleEntity['publisher']);
        $this->assertStringEndsWith('/articles/' . $article->id . '/five-things-to-know', $articleEntity['mainEntityOfPage']);
    }

    /**
     * Build an Article record via its Eloquent factory. make() never touches
     * the database, and the Twill slugs relation is primed so getSlug()
     * resolves URL properties without one.
     */
    protected function articleFixture(): Article
    {
        $article = Article::factory()->withoutParents()->make([
            'id' => 99,
            'title' => 'Five Things to Know',
            'heading' => '<p>An introduction to the exhibition.</p>',
            'list_description' => '<p>Five things you need to know about the show.</p>',
            'date' => \Carbon\Carbon::parse('2024-03-15'),
            'updated_at' => \Carbon\Carbon::parse('2024-04-01'),
        ]);
        $article->authors = collect([
            (object) ['title' => 'Jane Doe'],
            (object) ['title' => 'John Smith'],
        ]);
        $article->categories = collect([
            (object) ['name' => 'Art + Technology'],
            (object) ['name' => 'Exhibitions'],
        ]);

        return $this->withSlug($article, 'five-things-to-know', \App\Models\Slugs\ArticleSlug::class);
    }

    public function test_article_mapper_adds_author_url_when_author_has_id(): void
    {
        $manager = new JsonLdManager();

        $article = $this->articleFixture();
        $article->authors = collect([(object) ['title' => 'Jane Doe', 'id' => 5]]);

        $manager->addModelEntity($article, $this->definitionFor($article));
        $articleEntity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'BlogPosting');

        $this->assertSame('Jane Doe', $articleEntity['author'][0]['name']);
        $this->assertStringEndsWith('/authors/5', $articleEntity['author'][0]['url']);
    }

    public function test_event_mapper_duration_falls_back_to_start_and_end_time(): void
    {
        $manager = new JsonLdManager();

        $event = $this->eventFixture([
            'date_start' => null,
            'date_end' => null,
            'start_time' => 'PT18H00M',
            'end_time' => 'PT21H00M',
        ]);

        $manager->addModelEntity($event, $this->definitionFor($event));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Event');

        $this->assertSame('PT3H', $entity['duration']);
    }

    public function test_graph_contains_a_single_global_definition_per_id(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity($this->exhibitionFixture(), $this->definitionFor($this->exhibitionFixture()));
        $manager->addModelEntity($this->articleFixture(), $this->definitionFor($this->articleFixture()));

        $script = $manager->renderGraphScript();
        $graph = $this->extractGraph($script);

        // Page entities must reference the organization by @id rather than
        // duplicating it, so each global @id has exactly one definition.
        $ids = array_map(static fn (array $entity) => $entity['@id'] ?? null, $graph);

        $this->assertCount(1, array_keys($ids, 'https://www.artic.edu/#organization', true));
        $this->assertCount(1, array_keys($ids, 'https://www.artic.edu/#website', true));
        $this->assertStringContainsString('"organizer":{"@id":"https://www.artic.edu/#organization"}', $script);
        $this->assertStringContainsString('"publisher":{"@id":"https://www.artic.edu/#organization"}', $script);
        $this->assertStringNotContainsString('"@type":"Organization","name":"Art Institute of Chicago"', $script);
    }

    public function test_person_mapper_for_author(): void
    {
        $manager = new JsonLdManager();

        $author = $this->authorFixture();

        $manager->addModelEntity($author, $this->definitionFor($author));
        $script = $manager->renderGraphScript();
        $person = $this->findEntity($this->extractGraph($script), 'Person');

        $this->assertNotNull($person);
        $this->assertSame('Jane Doe', $person['name']);
        $this->assertSame('An art historian and writer.', $person['description']);
        $this->assertSame('Curator', $person['jobTitle']);
        $this->assertStringEndsWith('/authors/5/jane-doe', $person['url']);
        // The hero media primed via withMedia() resolves to an image URL
        $this->assertIsString($person['image'] ?? null);
        $this->assertStringStartsWith('http', $person['image']);
    }

    public function test_person_mapper_omits_missing_job_title(): void
    {
        $manager = new JsonLdManager();

        $author = $this->authorFixture();
        $author->job_title = null;

        $manager->addModelEntity($author, $this->definitionFor($author));
        $person = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Person');

        $this->assertNotNull($person);
        $this->assertArrayNotHasKey('jobTitle', $person);
    }

    public function test_artist_mapper_emits_person_for_individual(): void
    {
        $manager = new JsonLdManager();

        $artist = $this->apiModel(Artist::factory()->make([
            'id' => 8,
            'title' => 'Vincent van Gogh',
            'birth_date' => '1853-03-30',
            'death_date' => '1890-07-29',
            'birth_place' => 'Zundert',
            'nationality' => 'Dutch',
        ]));

        $manager->addModelEntity($artist, $this->definitionFor($artist));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Person');

        $this->assertNotNull($entity);
        $this->assertSame('Vincent van Gogh', $entity['name']);
        $this->assertSame('1853-03-30', $entity['birthDate']);
        $this->assertSame('1890-07-29', $entity['deathDate']);
        $this->assertSame('Zundert', $entity['birthPlace']);
        $this->assertSame('Dutch', $entity['nationality']);
        $this->assertStringEndsWith('/artists/8/vincent-van-gogh', $entity['url']);
    }

    public function test_artist_mapper_emits_organization_for_corporate_body(): void
    {
        $manager = new JsonLdManager();

        $artist = $this->apiModel(Artist::factory()->make([
            'title' => 'Aztec (Mexica)',
            'agent_type_title' => 'Culture',
            'agent_type_id' => 2,
            'ulan_id' => '500115588',
        ]));

        $manager->addModelEntity($artist, $this->definitionFor($artist));
        $graph = $this->extractGraph($manager->renderGraphScript());

        // The global Museum entity is also an Organization; pick the artist one.
        $organizations = array_values(array_filter($graph, static fn (array $entity) => ($entity['name'] ?? null) === 'Aztec (Mexica)'));
        $organization = $organizations[0] ?? null;

        $this->assertNotNull($organization);
        $this->assertSame('Organization', $organization['@type']);
        $this->assertSame('https://vocab.getty.edu/ulan/500115588', $organization['additionalType']);
        $this->assertArrayNotHasKey('birthDate', $organization);
    }

    public function test_artist_mapper_emits_person_for_dateless_individual(): void
    {
        $manager = new JsonLdManager();

        $artist = $this->apiModel(Artist::factory()->make([
            'title' => 'Terry Allen',
            'birth_date' => null,
            'death_date' => null,
        ]));

        $manager->addModelEntity($artist, $this->definitionFor($artist));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Person');

        $this->assertNotNull($entity);
        $this->assertSame('Terry Allen', $entity['name']);
        $this->assertArrayNotHasKey('birthDate', $entity);
    }

    public function test_artist_group_field_overrides_title_pattern(): void
    {
        $manager = new JsonLdManager();

        // Person-like name, but the API classifies the agent as a Culture.
        $artist = $this->apiModel(Artist::factory()->make([
            'title' => 'Terry Allen',
            'birth_date' => null,
            'death_date' => null,
            'agent_type_title' => 'Culture',
            'agent_type_id' => 2,
        ]));

        $manager->addModelEntity($artist, $this->definitionFor($artist));
        $graph = $this->extractGraph($manager->renderGraphScript());
        $cultures = array_values(array_filter($graph, static fn (array $entity) => ($entity['name'] ?? null) === 'Terry Allen'));

        $this->assertSame('Organization', $cultures[0]['@type'] ?? null);

        // Group-like name, but the API classifies the agent as an Individual.
        $manager = new JsonLdManager();

        $artist = $this->apiModel(Artist::factory()->make([
            'title' => 'Studio of Rembrandt',
            'agent_type_title' => 'Individual',
        ]));

        $manager->addModelEntity($artist, $this->definitionFor($artist));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Person');

        $this->assertSame('Studio of Rembrandt', $entity['name'] ?? null);
    }

    public function test_is_group_agent_reads_group_id_when_title_missing(): void
    {
        $this->assertTrue(SchemaMapper::isGroupAgent((object) ['agent_type_id' => 2, 'title' => 'Terry Allen']));
        $this->assertFalse(SchemaMapper::isGroupAgent((object) ['agent_type_id' => 7, 'title' => 'Aztec (Mexica)']));
        $this->assertFalse(SchemaMapper::isGroupAgent(null));
    }

    public function test_place_mapper_for_gallery(): void
    {
        $manager = new JsonLdManager();

        $gallery = $this->apiModel(Gallery::factory()->make([
            'id' => 2,
            'title' => 'Gallery 100',
            'description' => '<p>A gallery of European art.</p>',
            'latitude' => 41.8796,
            'longitude' => -87.6237,
        ]));

        $manager->addModelEntity($gallery, $this->definitionFor($gallery));
        $place = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Place');

        $this->assertNotNull($place);
        $this->assertSame('Gallery 100', $place['name']);
        $this->assertSame('A gallery of European art.', $place['description']);
        $this->assertSame(41.8796, $place['geo']['latitude']);
        $this->assertSame(-87.6237, $place['geo']['longitude']);
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $place['containedInPlace']);
        $this->assertStringEndsWith('/galleries/2/gallery-100', $place['url']);
    }

    public function test_collection_page_mapper_for_department(): void
    {
        $manager = new JsonLdManager();

        $department = $this->apiModel(Department::factory()->make([
            'id' => 3,
            'title' => 'Painting and Sculpture of Europe',
            'description' => '<p>Works from the European collection.</p>',
        ]));

        $manager->addModelEntity($department, $this->definitionFor($department));
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'CollectionPage');

        $this->assertNotNull($page);
        $this->assertSame('Painting and Sculpture of Europe', $page['name']);
        $this->assertSame('en', $page['inLanguage']);
        $this->assertSame(['@id' => 'https://www.artic.edu/#website'], $page['isPartOf']);
        $this->assertStringEndsWith('/departments/3/painting-and-sculpture-of-europe', $page['url']);
    }

    public function test_article_mapper_for_highlight(): void
    {
        $manager = new JsonLdManager();

        $highlight = Highlight::factory()->make([
            'id' => 11,
            'title' => 'A Closer Look at Nighthawks',
            'short_copy' => '<p>Explore Edward Hopper\'s iconic painting.</p>',
        ]);
        $highlight = $this->withSlug($highlight, 'a-closer-look-at-nighthawks', \App\Models\Slugs\HighlightSlug::class);

        $manager->addModelEntity($highlight, $this->definitionFor($highlight));
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Article');

        $this->assertNotNull($page);
        $this->assertSame('Article', $page['@type']);
        $this->assertSame('A Closer Look at Nighthawks', $page['name']);
        $this->assertSame('en', $page['inLanguage']);
        $this->assertSame('Explore Edward Hopper\'s iconic painting.', $page['description']);
        $this->assertStringEndsWith('/highlights/11/a-closer-look-at-nighthawks', $page['url']);
    }

    public function test_video_object_mapper(): void
    {
        $manager = new JsonLdManager();

        $video = $this->videoFixture();

        $manager->addModelEntity($video, $this->definitionFor($video));
        $script = $manager->renderGraphScript();
        $videoEntity = $this->findEntity($this->extractGraph($script), 'VideoObject');

        $this->assertNotNull($videoEntity);
        $this->assertSame($video->title, $videoEntity['name']);
        $this->assertSame('PT3M5S', $videoEntity['duration']);
        $this->assertSame('https://youtube.com/watch?v=abc123', $videoEntity['contentUrl']);
        $this->assertSame('https://www.youtube.com/embed/abc123', $videoEntity['embedUrl']);
        $this->assertSame('https://img.youtube.com/vi/abc123/hqdefault.jpg', $videoEntity['thumbnailUrl']);
        $this->assertStringContainsString('Welcome to the studio. This is the transcript.', $script);
        $this->assertStringContainsString('"uploadDate":"2024-02-10T12:00:00', $script);
        $this->assertStringEndsWith('/videos/' . $video->id . '/inside-the-studio', $videoEntity['url']);
    }

    /**
     * Build a Video record via its Eloquent factory, DB-free (see
     * articleFixture()). video_url/embed_url are computed accessors on the
     * model, so no media records are required.
     */
    protected function videoFixture(): Video
    {
        $video = Video::factory()->withoutParents()->make([
            'id' => 21,
            'title' => 'Inside the Studio',
            'list_description' => '<p>A look behind the scenes.</p>',
            'is_short' => false,
            'is_captioned' => true,
            'duration' => 185,
            'youtube_id' => 'abc123',
            'thumbnail_url' => 'https://img.youtube.com/vi/abc123/hqdefault.jpg',
            'uploaded_at' => \Carbon\Carbon::parse('2024-02-10 12:00:00'),
        ]);
        $video->standardCaption = (object) ['file' => 'Welcome to the studio. This is the transcript.'];

        return $this->withSlug($video, 'inside-the-studio', \App\Models\Slugs\VideoSlug::class);
    }

    public function test_video_object_mapper_uses_shorts_route(): void
    {
        $manager = new JsonLdManager();

        $video = $this->videoFixture();
        $video->is_short = true;
        $video->is_captioned = false;

        $manager->addModelEntity($video, $this->definitionFor($video));
        $videoEntity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'VideoObject');

        $this->assertNotNull($videoEntity);
        $this->assertStringEndsWith('/videos/shorts/' . $video->id, $videoEntity['url']);
        $this->assertArrayNotHasKey('transcript', $videoEntity);
    }

    public function test_playlist_mapper_builds_item_list(): void
    {
        $manager = new JsonLdManager();

        $playlist = Playlist::factory()->withoutParents()->make([
            'id' => 31,
            'title' => 'Artist Talks',
            'description' => '<p>Conversations with artists.</p>',
        ]);

        $first = $this->videoFixture();
        $second = $this->videoFixture();
        $second->id = 22;
        $second->title = 'A Second Talk';
        $second->youtube_id = 'def456';
        $first->pivot = (object) ['position' => 1];
        $second->pivot = (object) ['position' => 2];
        $playlist->videos = collect([$first, $second]);

        $manager->addModelEntity($playlist, $this->definitionFor($playlist));
        $list = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'ItemList');

        $this->assertNotNull($list);
        $this->assertSame($playlist->title, $list['name']);
        $this->assertCount(2, $list['itemListElement']);
        $this->assertSame(1, $list['itemListElement'][0]['position']);
        $this->assertSame('Inside the Studio', $list['itemListElement'][0]['item']['name']);
        $this->assertSame('VideoObject', $list['itemListElement'][0]['item']['@type']);
        $this->assertSame('A Second Talk', $list['itemListElement'][1]['item']['name']);
    }

    public function test_publication_issue_mapper(): void
    {
        $manager = new JsonLdManager();

        $issue = MagazineIssue::factory()->make([
            'id' => 41,
            'title' => 'Fall 2024',
            'list_description' => '<p>The fall issue of the museum magazine.</p>',
            'publish_start_date' => \Carbon\Carbon::parse('2024-09-01'),
        ]);
        $issue = $this->withSlug($issue, 'fall-2024', \App\Models\Slugs\MagazineIssueSlug::class);

        $manager->addModelEntity($issue, $this->definitionFor($issue));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'PublicationIssue');

        $this->assertNotNull($entity);
        $this->assertSame('Fall 2024', $entity['name']);
        $this->assertSame('2024-09-01', substr($entity['datePublished'], 0, 10));
        $this->assertSame('Art Institute of Chicago magazine', $entity['isPartOf']['name']);
        $this->assertSame('Periodical', $entity['isPartOf']['@type']);
        $this->assertStringEndsWith('/magazine/issues/41/fall-2024', $entity['url']);
    }

    public function test_book_mapper_for_printed_publication(): void
    {
        $manager = new JsonLdManager();

        $book = PrintedPublication::factory()->make([
            'id' => 51,
            'title' => 'Van Gogh: The Complete Works',
            'short_description' => '<p>A comprehensive survey.</p>',
            'listing_description' => '<p>The definitive catalogue.</p>',
            'publication_date' => \Carbon\Carbon::parse('2023-11-15'),
            'isbn' => '978-0-86559-000-0',
            'number_of_pages' => 320,
        ]);
        $book = $this->withSlug($book, 'van-gogh-the-complete-works', \App\Models\Slugs\PrintedPublicationSlug::class);

        $manager->addModelEntity($book, $this->definitionFor($book));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Book');

        $this->assertNotNull($entity);
        $this->assertSame('Book', $entity['@type']);
        $this->assertSame('Van Gogh: The Complete Works', $entity['name']);
        $this->assertSame('978-0-86559-000-0', $entity['isbn']);
        $this->assertSame('320', $entity['numberOfPages']);
        $this->assertSame('2023-11-15', substr($entity['datePublished'], 0, 10));
        $this->assertStringEndsWith('/print-publications/51/van-gogh-the-complete-works', $entity['url']);
    }

    public function test_book_mapper_for_digital_publication(): void
    {
        $manager = new JsonLdManager();

        $publication = DigitalPublication::factory()->withoutParents()->make([
            'id' => 61,
            'title' => 'Impressionism and Beyond',
            'listing_description' => '<p>An interactive digital publication.</p>',
            'publication_date' => \Carbon\Carbon::parse('2024-01-20'),
        ]);
        $publication = $this->withSlug($publication, 'impressionism-and-beyond', \App\Models\Slugs\DigitalPublicationSlug::class);

        $manager->addModelEntity($publication, $this->definitionFor($publication));
        $book = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Book');

        $this->assertNotNull($book);
        $this->assertSame(['Book', 'DigitalDocument'], $book['@type']);
        $this->assertSame('text/html', $book['encodingFormat']);
        $this->assertSame($publication->title, $book['name']);
        $this->assertStringEndsWith('/digital-publications/' . $publication->id . '/impressionism-and-beyond', $book['url']);
        $this->assertSame($book['url'], $book['@id']);
    }

    public function test_publication_article_mapper_reuses_article_and_links_book(): void
    {
        $manager = new JsonLdManager();

        $publication = DigitalPublication::factory()->withoutParents()->make([
            'id' => 61,
            'title' => 'Impressionism and Beyond',
            'publication_date' => \Carbon\Carbon::parse('2024-01-20'),
        ]);
        $publication = $this->withSlug($publication, 'impressionism-and-beyond', \App\Models\Slugs\DigitalPublicationSlug::class);

        $article = DigitalPublicationArticle::factory()->withoutParents()->make([
            'id' => 71,
            'title' => 'Monet in the Garden',
            'list_description' => '<p>How Monet composed his garden paintings.</p>',
            'article_type' => 'text',
            'date' => \Carbon\Carbon::parse('2024-02-01'),
        ]);
        $article = $this->withSlug($article, 'monet-in-the-garden', \App\Models\Slugs\DigitalPublicationArticleSlug::class);
        $article->authors = collect([
            (object) ['title' => 'Jane Doe'],
        ]);
        $article->digitalPublication = $publication;

        $manager->addModelEntity($article, $this->definitionFor($article));
        $articleEntity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Article');

        $this->assertNotNull($articleEntity);
        $this->assertSame($article->title, $articleEntity['headline']);
        $this->assertSame('How Monet composed his garden paintings.', $articleEntity['description']);
        $this->assertSame('Jane Doe', $articleEntity['author'][0]['name']);
        $this->assertSame('Book', $articleEntity['isPartOf']['@type']);
        $this->assertStringEndsWith('/digital-publications/61/impressionism-and-beyond', $articleEntity['isPartOf']['@id']);
        $this->assertStringContainsString('/digital-publications/61/impressionism-and-beyond/71/monet-in-the-garden', $articleEntity['url']);
    }

    public function test_learning_resource_mapper(): void
    {
        $manager = new JsonLdManager();

        $resource = $this->educatorResourceFixture([
            'id' => 81,
            'title' => 'The Language of Color',
            'short_description' => '<p>A classroom resource about color theory.</p>',
            'listing_description' => '<p>Activities for students.</p>',
        ]);
        $resource->categories = collect([
            (object) ['name' => 'High School', 'type' => 'audience'],
            (object) ['name' => 'Lesson Plan', 'type' => 'content'],
        ]);
        $resource = $this->withSlug($resource, 'the-language-of-color', \App\Models\Slugs\EducatorResourceSlug::class);

        $manager->addModelEntity($resource, $this->definitionFor($resource));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'LearningResource');

        $this->assertNotNull($entity);
        $this->assertSame('The Language of Color', $entity['name']);
        $this->assertSame('High School', $entity['educationalLevel']);
        $this->assertSame('Lesson Plan', $entity['learningResourceType']);
        $this->assertStringEndsWith('/educator-resources/81/the-language-of-color', $entity['url']);
    }

    public function test_web_application_mapper_for_experience(): void
    {
        $manager = new JsonLdManager();

        $experience = Experience::factory()->withoutParents()->make([
            'id' => 91,
            'title' => 'The Thread in the Labyrinth',
            'listing_description' => '<p>An interactive feature about the Thorne Miniature Rooms.</p>',
        ]);
        $experience = $this->withSlug($experience, 'the-thread-in-the-labyrinth', \App\Models\Slugs\ExperienceSlug::class);

        $manager->addModelEntity($experience, $this->definitionFor($experience));
        $app = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebApplication');

        $this->assertNotNull($app);
        $this->assertSame($experience->title, $app['name']);
        $this->assertSame('An interactive feature about the Thorne Miniature Rooms.', $app['description']);
        $this->assertSame('MultimediaApplication', $app['applicationCategory']);
        $this->assertStringEndsWith('/interactive-features/the-thread-in-the-labyrinth', $app['url']);
    }

    public function test_tourist_trip_mapper_builds_itinerary(): void
    {
        $manager = new JsonLdManager();

        $tour = MyMuseumTour::factory()->make([
            'id' => 101,
            'tour_json' => [
                'title' => 'My Afternoon at the Museum',
                'description' => 'A personal tour of favorites.',
                'touristType' => 'Art lover',
                'artworks' => [
                    [
                        'id' => 111,
                        'title' => 'Water Lilies',
                        'artist_title' => 'Claude Monet',
                        'display_date' => '1906',
                        'description' => 'A water lily painting.',
                        'image_id' => 'monet-waterlilies',
                    ],
                    [
                        'id' => 112,
                        'title' => 'The Bedroom',
                        'artist_title' => 'Vincent van Gogh',
                        'display_date' => '1889',
                        'image_id' => null,
                    ],
                ],
            ],
        ]);

        $manager->addModelEntity($tour, $this->definitionFor($tour));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'TouristTrip');

        $this->assertNotNull($entity);
        $this->assertSame('My Afternoon at the Museum', $entity['name']);
        $this->assertSame('Art lover', $entity['touristType']);
        $this->assertSame('ItemList', $entity['itinerary']['@type']);
        $this->assertCount(2, $entity['itinerary']['itemListElement']);
        $this->assertSame('Water Lilies', $entity['itinerary']['itemListElement'][0]['item']['name']);
        $this->assertSame('Claude Monet', $entity['itinerary']['itemListElement'][0]['item']['creator'][0]['name']);
        $this->assertSame('https://www.artic.edu/iiif/2/monet-waterlilies/full/843,/0/default.jpg', $entity['itinerary']['itemListElement'][0]['item']['image']);
        $this->assertStringEndsWith('/my-museum-tour/101', $entity['url']);
    }

    public function test_web_page_mapper_for_generic_page(): void
    {
        $manager = new JsonLdManager();

        $page = GenericPage::factory()->withoutParents()->make([
            'id' => 121,
            'title' => 'Visit with My Students',
            'short_description' => '<p>Plan your school visit.</p>',
            'listing_description' => '<p>Resources for educators.</p>',
            // The url attribute accessor resolves from the slug/ancestors when
            // redirect_url is empty; setting redirect_url keeps this DB-free.
            'redirect_url' => '/visit/visit-with-my-students',
            'updated_at' => \Carbon\Carbon::parse('2024-03-05'),
        ]);

        $manager->addModelEntity($page, $this->definitionFor($page));
        $pageEntity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebPage');

        $this->assertNotNull($pageEntity);
        $this->assertSame($page->title, $pageEntity['name']);
        $this->assertSame('Plan your school visit.', $pageEntity['description']);
        $this->assertArrayNotHasKey('dateModified', $pageEntity);
        $this->assertSame('en', $pageEntity['inLanguage']);
        $this->assertStringEndsWith('/visit/visit-with-my-students', $pageEntity['url']);
    }

    public function test_web_page_mapper_for_digital_explorer(): void
    {
        $manager = new JsonLdManager();

        $explorer = DigitalExplorer::factory()->withoutParents()->make([
            'id' => 131,
            'title' => 'The Giltwood Table',
        ]);
        $explorer = $this->withSlug($explorer, 'the-giltwood-table', \App\Models\Slugs\DigitalExplorerSlug::class);

        $manager->addModelEntity($explorer, $this->definitionFor($explorer));
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebPage');

        $this->assertNotNull($page);
        $this->assertSame($explorer->title, $page['name']);
        $this->assertStringEndsWith('/digital-explorers/' . $explorer->id . '/the-giltwood-table', $page['url']);
    }

    public function test_web_page_mapper_for_landing_page(): void
    {
        $manager = new JsonLdManager();

        $landingPage = LandingPage::factory()->withoutParents()->make([
            'id' => 141,
            'type_id' => 4, // Visit
            'title' => 'Visit',
            'listing_description' => '<p>Plan your visit to the museum.</p>',
        ]);
        $landingPage = $this->withSlug($landingPage, 'home', \App\Models\Slugs\LandingPageSlug::class);

        $manager->addModelEntity($landingPage, $this->definitionFor($landingPage));
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebPage');

        $this->assertNotNull($page);
        $this->assertSame($landingPage->title, $page['name']);
        $this->assertSame('en', $page['inLanguage']);
        $this->assertSame('http://localhost', $page['url']);
        // Home/Visit landing pages describe the museum itself: their WebPage
        // entity references the global Museum/Organization entity.
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $page['mainEntity']);
    }

    public function test_web_page_mapper_for_default_landing_page_has_no_museum_main_entity(): void
    {
        $manager = new JsonLdManager();

        $landingPage = LandingPage::factory()->withoutParents()->make([
            'id' => 142,
            'type_id' => 99, // Default
            'title' => 'About',
        ]);
        $landingPage = $this->withSlug($landingPage, 'about', \App\Models\Slugs\LandingPageSlug::class);

        $manager->addModelEntity($landingPage, $this->definitionFor($landingPage));
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebPage');

        $this->assertNotNull($page);
        $this->assertArrayNotHasKey('mainEntity', $page);
    }

    public function test_base_definition_alone_resolves_to_web_page_entity(): void
    {
        $manager = new JsonLdManager();

        // The definition is the shared FrontController base template only, with
        // no child override, so the model must still resolve to a WebPage that
        // carries the shared page properties.
        $page = GenericPage::factory()->withoutParents()->make([
            'id' => 151,
            'title' => 'Plan Your Visit',
            'description' => '<p>Everything you need to know before you arrive.</p>',
            'list_description' => '<p>A shorter listing description.</p>',
            'updated_at' => \Carbon\Carbon::parse('2024-06-01'),
        ]);
        $page = $this->withSlug($page, 'plan-your-visit', \App\Models\Slugs\GenericPageSlug::class);

        $manager->addModelEntity($page, $this->definitionFor($page, \App\Http\Controllers\FrontController::class));
        $entity = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebPage');

        $this->assertNotNull($entity);
        $this->assertSame('WebPage', $entity['@type']);
        $this->assertSame('Plan Your Visit', $entity['name']);
        $this->assertSame('Everything you need to know before you arrive.', $entity['description']);
        // The base template emits Thing-level properties only: CreativeWork-only
        // inLanguage/isPartOf must not leak onto the shared WebPage defaults.
        $this->assertArrayNotHasKey('inLanguage', $entity);
        $this->assertArrayNotHasKey('isPartOf', $entity);
        $this->assertSame('http://localhost', $entity['url']);
    }

    public function test_push_breadcrumbs_builds_breadcrumb_list(): void
    {
        $manager = new JsonLdManager();

        $manager->addBreadcrumbs([
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Artworks', 'url' => route('collection')],
            ['label' => 'Starry Night'],
        ]);

        $breadcrumbs = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'BreadcrumbList');

        $this->assertNotNull($breadcrumbs);
        $this->assertCount(3, $breadcrumbs['itemListElement']);
        $this->assertSame(1, $breadcrumbs['itemListElement'][0]['position']);
        $this->assertSame('Home', $breadcrumbs['itemListElement'][0]['name']);
        $this->assertSame('http://localhost', $breadcrumbs['itemListElement'][0]['item']);
        $this->assertSame(3, $breadcrumbs['itemListElement'][2]['position']);
        $this->assertSame('Starry Night', $breadcrumbs['itemListElement'][2]['name']);
        $this->assertArrayNotHasKey('item', $breadcrumbs['itemListElement'][2]);
    }

    /**
     * Build a factory-made Artwork API model, DB-free (see apiModel()).
     */
    protected function artworkFixture(array $attributes = []): Artwork
    {
        return $this->apiModel(Artwork::factory()->make(array_merge([
            'id' => 1,
            'title' => 'Starry Night',
            'main_reference_number' => '1234',
            'artist_title' => 'Vincent van Gogh',
            'date_display' => '1889',
            'medium_display' => 'Oil on canvas',
            'dimensions' => '73.7 × 92.1 cm',
            'artwork_type_title' => 'Painting',
            'place_of_origin' => 'France',
            'credit_line' => 'Gift of Example',
            'description' => '<p>A starry night scene.</p>',
            'copyright_notice' => 'Public domain',
            'subject_titles' => ['Landscape'],
            'style_titles' => ['Post-Impressionism'],
            'category_titles' => ['Painting'],
            'classification_title' => 'Painting',
            'department_title' => 'Arts of the Americas',
            'gallery_title' => 'Gallery 100',
            'dimensions_detail' => [
                ['width' => 73.7, 'height' => 92.1, 'depth' => null, 'unit' => 'cm'],
            ],
            'image_id' => 'abc',
        ], $attributes)));
    }

    /**
     * Build a factory-made Exhibition API model, DB-free (see apiModel()).
     * The date_start/date_end accessors resolve from aic_start_at/aic_end_at,
     * so the fixture sets those API fields.
     */
    protected function exhibitionFixture(array $attributes = []): Exhibition
    {
        return $this->apiModel(Exhibition::factory()->make(array_merge([
            'id' => 42,
            'title' => 'Van Gogh and the Avant-Garde',
            // The model's description accessor wraps the raw value in <p> tags
            // and returns a non-null '<p></p>' when empty, so supply the text
            // directly for the list_description fallback to be reached.
            'description' => 'An exhibition about Van Gogh.',
            'list_description' => '<p>An exhibition about Van Gogh.</p>',
            'gallery_title' => 'Gallery 100',
            'aic_start_at' => '2024-05-01',
            'aic_end_at' => '2024-09-08',
        ], $attributes)));
    }

    /**
     * Build an Author record via its Eloquent factory, DB-free (see
     * articleFixture()). The Twill slugs and medias relations are primed so
     * getSlug() and imageFront() resolve without a database.
     */
    protected function authorFixture(): Author
    {
        $author = Author::factory()->make([
            'id' => 5,
            'title' => 'Jane Doe',
            'description' => '<p>An art historian and writer.</p>',
            'list_description' => '<p>Short list description.</p>',
            'job_title' => 'Curator',
        ]);

        $author = $this->withSlug($author, 'jane-doe', \App\Models\Slugs\AuthorSlug::class);
        $this->withMedia($author, 'author');

        return $author;
    }

    /**
     * Build an Event record via its Eloquent factory, DB-free. Event's
     * date_start / date_end accessors always resolve from the event_metas
     * relation (a database query), so the factory-built record is wrapped in
     * an anonymous subclass that supplies those dates from a preloaded
     * collection instead. Pass 'date_start' => null / 'date_end' => null to
     * exercise the start_time/end_time duration fallback.
     */
    protected function eventFixture(array $overrides = []): Event
    {
        $event = Event::factory()->withoutParents()->make(array_merge([
            'id' => 7,
            'title' => 'Member Preview Night',
            'slug' => 'member-preview-night',
            'short_description' => '<p>Join us for a preview.</p>',
            'location' => 'Gallery 101',
            'is_virtual_event' => false,
            'is_free' => true,
            'is_ticketed' => false,
            'is_sold_out' => false,
            'audience' => 3,
            'alt_audiences' => [],
            'event_type' => 5,
            'alt_types' => [],
            'rsvp_link' => 'https://www.artic.edu/rsvp',
            'door_time' => '18:00',
        ], $overrides));

        $fixture = new class() extends Event {
            /** @var \Illuminate\Support\Collection<int, array{date: \Carbon\CarbonInterface, date_end: \Carbon\CarbonInterface}>|null */
            public $fixtureDates;

            public function getAllDatesAttribute(): \Illuminate\Support\Collection
            {
                return $this->fixtureDates ?? collect();
            }
        };

        // forceFill so non-fillable attributes (e.g. id) survive the wrap
        $fixture->forceFill($event->getAttributes());

        $start = $overrides['date_start'] ?? '2024-06-01 18:00:00';
        $end = $overrides['date_end'] ?? '2024-06-01 21:00:00';

        if ($start === null || $end === null) {
            $fixture->fixtureDates = collect();
        } else {
            $fixture->fixtureDates = collect([
                [
                    'date' => \Carbon\Carbon::parse($start),
                    'date_end' => \Carbon\Carbon::parse($end),
                ],
            ]);
        }

        return $this->withSlug($fixture, 'member-preview-night', \App\Models\Slugs\EventSlug::class);
    }

    /**
     * Build an EducatorResource record via its Eloquent factory, DB-free.
     * EducatorResource is translatable: setting translated attributes via the
     * constructor would query the translations relation, so the fixture
     * primes an empty translations relation and stores the supplied values as
     * plain attributes, which the translatable behavior falls back to.
     */
    protected function educatorResourceFixture(array $attributes = []): EducatorResource
    {
        $resource = EducatorResource::factory()->make();
        $resource->setRelation('translations', collect());
        $resource->setRawAttributes(array_merge($resource->getAttributes(), $attributes));

        return $resource;
    }

    /**
     * Pull the JSON payload out of a rendered script tag.
     */
    protected function extractJson(string $script): array
    {
        $this->assertStringStartsWith('<script type="application/ld+json">', $script);
        $this->assertStringEndsWith('</script>', $script);

        $json = substr($script, strlen('<script type="application/ld+json">'), -strlen('</script>'));

        return json_decode($json, true);
    }

    /**
     * Pull the @graph array out of a rendered graph script tag.
     */
    protected function extractGraph(string $script): array
    {
        $payload = $this->extractJson($script);

        $this->assertSame('https://schema.org', $payload['@context']);

        return $payload['@graph'];
    }

    /**
     * Find the first graph entity carrying the given @type.
     */
    protected function findEntity(array $graph, string $type): ?array
    {
        foreach ($graph as $entity) {
            $types = (array) ($entity['@type'] ?? []);

            if (in_array($type, $types, true)) {
                return $entity;
            }
        }

        return null;
    }
}
