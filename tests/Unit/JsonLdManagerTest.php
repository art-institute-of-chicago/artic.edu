<?php

namespace Tests\Unit;

use App\Helpers\StringHelpers;
use App\Libraries\SchemaOrg\JsonLdManager;
use App\Libraries\SchemaOrg\SchemaMapper;
use App\Models\Event;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Unit\Stubs\StubArticle;
use Tests\Unit\Stubs\StubArtist;
use Tests\Unit\Stubs\StubArtwork;
use Tests\Unit\Stubs\StubAuthor;
use Tests\Unit\Stubs\StubDepartment;
use Tests\Unit\Stubs\StubDigitalExplorer;
use Tests\Unit\Stubs\StubDigitalPublication;
use Tests\Unit\Stubs\StubDigitalPublicationArticle;
use Tests\Unit\Stubs\StubEducatorResource;
use Tests\Unit\Stubs\StubEvent;
use Tests\Unit\Stubs\StubExhibition;
use Tests\Unit\Stubs\StubExperience;
use Tests\Unit\Stubs\StubGallery;
use Tests\Unit\Stubs\StubGenericPage;
use Tests\Unit\Stubs\StubHighlight;
use Tests\Unit\Stubs\StubLandingPage;
use Tests\Unit\Stubs\StubMagazineIssue;
use Tests\Unit\Stubs\StubMyMuseumTour;
use Tests\Unit\Stubs\StubPlaylist;
use Tests\Unit\Stubs\StubPrintedPublication;
use Tests\Unit\Stubs\StubVideo;
use Tests\Unit\Stubs\StubWebPage;

class JsonLdManagerTest extends BaseTestCase
{
    public function test_mapper_for_returns_null_for_unmapped_models(): void
    {
        $manager = new JsonLdManager();

        $this->assertNull($manager->mapperFor(new \stdClass()));
    }

    public function test_add_model_entity_registers_entity(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubArtwork(), self::definitions()[StubArtwork::class]);

        $artwork = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'VisualArtwork');

        $this->assertNotNull($artwork);
        $this->assertSame('Starry Night', $artwork['name']);
    }

    public function test_add_model_entity_registers_entity_and_returns_nothing(): void
    {
        $manager = new JsonLdManager();

        $this->assertNull($manager->addModelEntity(new StubArtwork(), self::definitions()[StubArtwork::class]));

        $artwork = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'VisualArtwork');

        $this->assertNotNull($artwork);
        $this->assertSame('Starry Night', $artwork['name']);
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

        $manager->addModelEntity(new StubArtwork(), self::definitions()[StubArtwork::class]);
        $manager->addModelEntity(new StubArticle(), self::definitions()[StubArticle::class]);

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
        $this->assertCount(4, $organization['sameAs']);
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

        $manager->addModelEntity(new StubArtwork(), self::definitions()[StubArtwork::class]);
        $script = $manager->renderGraphScript();
        $artwork = $this->findEntity($this->extractGraph($script), 'VisualArtwork');

        $this->assertNotNull($artwork);
        $this->assertStringContainsString('"@type":"VisualArtwork"', $script);
        $this->assertStringContainsString('"name":"Starry Night"', $script);
        $this->assertStringContainsString('"alternateName":"1234"', $script);
        $this->assertStringContainsString('"description":"A starry night scene."', $script);
        $this->assertStringContainsString('"identifier":{"@type":"PropertyValue","propertyID":"main_reference_number","value":"1234"}', $script);
        $this->assertStringContainsString('"artist":[{"@type":"Person","name":"Vincent van Gogh"}]', $script);
        $this->assertStringContainsString('"creator":[{"@type":"Person","name":"Vincent van Gogh"}]', $script);
        $this->assertStringContainsString('"width":{"@type":"QuantitativeValue","value":73.7,"unitCode":"CMT"}', $script);
        $this->assertStringContainsString('"height":{"@type":"QuantitativeValue","value":92.1,"unitCode":"CMT"}', $script);
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
        $this->assertStringContainsString('https://lakeimagesweb.artic.edu/iiif/2/abc/full/!300,300/0/default.jpg', $script);
        $this->assertStringEndsWith('/artworks/1/starry-night', $artwork['url']);
        $this->assertStringEndsWith('/artworks/1/starry-night', $artwork['mainEntityOfPage']);
    }

    public function test_artwork_creator_emits_organization_for_culture(): void
    {
        $manager = new JsonLdManager();

        $stub = new StubArtwork();
        $stub->artists = collect([
            (object) ['title' => 'Aztec (Mexica)', 'birth_date' => null, 'death_date' => null, 'ulan_id' => '500115588'],
        ]);

        $manager->addModelEntity($stub, self::definitions()[StubArtwork::class]);
        $artwork = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'VisualArtwork');

        $this->assertSame('Organization', $artwork['creator'][0]['@type']);
        $this->assertSame('Aztec (Mexica)', $artwork['creator'][0]['name']);
        $this->assertSame('https://vocab.getty.edu/ulan/500115588', $artwork['creator'][0]['additionalType']);
    }

    public function test_artwork_creator_falls_back_to_aat_for_culture_without_ulan(): void
    {
        $manager = new JsonLdManager();

        $stub = new StubArtwork();
        $stub->artists = collect([
            (object) ['title' => 'Unknown Yoruba artist', 'birth_date' => null, 'death_date' => null],
        ]);

        $manager->addModelEntity($stub, self::definitions()[StubArtwork::class]);
        $artwork = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'VisualArtwork');

        $this->assertSame('Organization', $artwork['creator'][0]['@type']);
        $this->assertSame('http://vocab.getty.edu/aat/300387177', $artwork['creator'][0]['additionalType']);
    }

    public function test_exhibition_mapper(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubExhibition(), self::definitions()[StubExhibition::class]);
        $script = $manager->renderGraphScript();
        $exhibition = $this->findEntity($this->extractGraph($script), 'ExhibitionEvent');

        $this->assertNotNull($exhibition);
        $this->assertStringContainsString('"@type":"ExhibitionEvent"', $script);
        $this->assertStringContainsString('"name":"Van Gogh and the Avant-Garde"', $script);
        $this->assertStringContainsString('"description":"An exhibition about Van Gogh."', $script);
        $this->assertStringContainsString('"startDate":"2024-05-01T00:00:00', $script);
        $this->assertStringContainsString('"eventStatus":"https://schema.org/EventScheduled"', $script);
        $this->assertStringContainsString('"eventAttendanceMode":"https://schema.org/OfflineEventAttendanceMode"', $script);
        $this->assertStringContainsString('"inLanguage":"en"', $script);
        $this->assertStringContainsString('"location":{"@type":"Place","name":"Gallery 100","address":{"@type":"PostalAddress","streetAddress":"111 S Michigan Ave","addressLocality":"Chicago","addressRegion":"IL","postalCode":"60603","addressCountry":"US"},"containedInPlace":{"@id":"https://www.artic.edu/#organization"}}', $script);
        $this->assertStringNotContainsString('isAccessibleForFree', $script);
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $exhibition['organizer']);
        $this->assertStringEndsWith('/exhibitions/42/van-gogh-and-the-avant-garde', $exhibition['url']);
    }

    public function test_event_mapper(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubEvent(), self::definitions()[StubEvent::class]);
        $script = $manager->renderGraphScript();
        $event = $this->findEntity($this->extractGraph($script), 'Event');

        $this->assertNotNull($event);
        $this->assertStringContainsString('"@type":"Event"', $script);
        $this->assertStringContainsString('"duration":"PT3H"', $script);
        $this->assertStringContainsString('"location":{"@type":"Place","name":"Gallery 101","address":{"@type":"PostalAddress","streetAddress":"111 S Michigan Ave","addressLocality":"Chicago","addressRegion":"IL","postalCode":"60603","addressCountry":"US"}}', $script);
        $this->assertStringContainsString('"eventAttendanceMode":"https://schema.org/OfflineEventAttendanceMode"', $script);
        $this->assertStringContainsString('"isAccessibleForFree":true', $script);
        $this->assertStringContainsString('"audience":{"@type":"Audience","audienceType":"General Public"}', $script);
        $this->assertStringContainsString('"keywords":"Talk"', $script);
        $this->assertStringContainsString('"inLanguage":"en"', $script);
        $this->assertStringContainsString('"offers":{"@type":"Offer","url":"https://www.artic.edu/rsvp","availability":"https://schema.org/InStock","price":"0","priceCurrency":"USD"}', $script);
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $event['organizer']);
        $this->assertStringEndsWith('/events/7/member-preview-night', $event['url']);
    }

    public function test_virtual_event_mapper_uses_virtual_location_and_online_mode(): void
    {
        $manager = new JsonLdManager();

        $stub = new StubEvent();
        $stub->is_virtual_event = true;
        $stub->virtual_event_url = 'https://zoom.us/j/123';
        $stub->is_free = false;

        $manager->addModelEntity($stub, self::definitions()[StubEvent::class]);
        $script = $manager->renderGraphScript();

        $this->assertStringContainsString('"location":{"@type":"VirtualLocation","url":"https://zoom.us/j/123"}', $script);
        $this->assertStringContainsString('"eventAttendanceMode":"https://schema.org/OnlineEventAttendanceMode"', $script);
        $this->assertStringNotContainsString('isAccessibleForFree', $script);
    }

    public function test_article_mapper(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubArticle(), self::definitions()[StubArticle::class]);
        $script = $manager->renderGraphScript();
        $article = $this->findEntity($this->extractGraph($script), 'BlogPosting');

        $this->assertNotNull($article);
        $this->assertStringContainsString('"@type":"BlogPosting"', $script);
        $this->assertStringContainsString('"headline":"Five Things to Know"', $script);
        $this->assertStringContainsString('"description":"An introduction to the exhibition."', $script);
        $this->assertStringContainsString('"abstract":"Five things you need to know about the show."', $script);
        $this->assertStringContainsString('"keywords":"Art + Technology, Exhibitions"', $script);
        $this->assertStringContainsString('"inLanguage":"en"', $script);
        $this->assertStringContainsString('https://lakeimagesweb.artic.edu/iiif/2/art/full/!300,300/0/default.jpg', $script);
        $this->assertStringContainsString('"author":[{"@type":"Person","name":"Jane Doe"},{"@type":"Person","name":"John Smith"}]', $script);
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $article['publisher']);
        $this->assertStringEndsWith('/articles/99/five-things-to-know', $article['mainEntityOfPage']);
    }

    public function test_article_mapper_adds_author_url_when_author_has_id(): void
    {
        $manager = new JsonLdManager();

        $stub = new StubArticle();
        $stub->authors = collect([(object) ['title' => 'Jane Doe', 'id' => 5]]);

        $manager->addModelEntity($stub, self::definitions()[StubArticle::class]);
        $article = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'BlogPosting');

        $this->assertSame('Jane Doe', $article['author'][0]['name']);
        $this->assertStringEndsWith('/authors/5', $article['author'][0]['url']);
    }

    public function test_event_mapper_duration_falls_back_to_start_and_end_time(): void
    {
        $manager = new JsonLdManager();

        $stub = new StubEvent();
        $stub->date_start = null;
        $stub->date_end = null;
        $stub->start_time = 'PT18H00M';
        $stub->end_time = 'PT21H00M';

        $manager->addModelEntity($stub, self::definitions()[StubEvent::class]);
        $event = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Event');

        $this->assertSame('PT3H', $event['duration']);
    }

    public function test_graph_contains_a_single_global_definition_per_id(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubExhibition(), self::definitions()[StubExhibition::class]);
        $manager->addModelEntity(new StubArticle(), self::definitions()[StubArticle::class]);

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

        $manager->addModelEntity(new StubAuthor(), self::definitions()[StubAuthor::class]);
        $script = $manager->renderGraphScript();
        $person = $this->findEntity($this->extractGraph($script), 'Person');

        $this->assertNotNull($person);
        $this->assertSame('Jane Doe', $person['name']);
        $this->assertSame('An art historian and writer.', $person['description']);
        $this->assertSame('Curator', $person['jobTitle']);
        $this->assertStringEndsWith('/authors/5/jane-doe', $person['url']);
        $this->assertStringContainsString('https://lakeimagesweb.artic.edu/iiif/2/author/full/!3000,3000/0/default.jpg', $script);
    }

    public function test_person_mapper_omits_missing_job_title(): void
    {
        $manager = new JsonLdManager();

        $stub = new StubAuthor();
        $stub->job_title = null;

        $manager->addModelEntity($stub, self::definitions()[StubAuthor::class]);
        $person = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Person');

        $this->assertNotNull($person);
        $this->assertArrayNotHasKey('jobTitle', $person);
    }

    public function test_artist_mapper_emits_person_for_individual(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubArtist(), self::definitions()[StubArtist::class]);
        $artist = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Person');

        $this->assertNotNull($artist);
        $this->assertSame('Vincent van Gogh', $artist['name']);
        $this->assertSame('1853-03-30', $artist['birthDate']);
        $this->assertSame('1890-07-29', $artist['deathDate']);
        $this->assertSame('Zundert', $artist['birthPlace']);
        $this->assertSame('Dutch', $artist['nationality']);
        $this->assertStringEndsWith('/artists/8/vincent-van-gogh', $artist['url']);
    }

    public function test_artist_mapper_emits_organization_for_corporate_body(): void
    {
        $manager = new JsonLdManager();

        $stub = new StubArtist();
        $stub->birth_date = null;
        $stub->death_date = null;
        $stub->ulan_id = '500115588';

        $manager->addModelEntity($stub, self::definitions()[StubArtist::class]);
        $graph = $this->extractGraph($manager->renderGraphScript());

        // The global Museum entity is also an Organization; pick the artist one.
        $organizations = array_values(array_filter($graph, static fn (array $entity) => ($entity['name'] ?? null) === 'Vincent van Gogh'));
        $organization = $organizations[0] ?? null;

        $this->assertNotNull($organization);
        $this->assertSame('Organization', $organization['@type']);
        $this->assertSame('https://vocab.getty.edu/ulan/500115588', $organization['additionalType']);
        $this->assertArrayNotHasKey('birthDate', $organization);
    }

    public function test_place_mapper_for_gallery(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubGallery(), self::definitions()[StubGallery::class]);
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

        $manager->addModelEntity(new StubDepartment(), self::definitions()[StubDepartment::class]);
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'CollectionPage');

        $this->assertNotNull($page);
        $this->assertSame('Painting and Sculpture of Europe', $page['name']);
        $this->assertSame(['@id' => 'https://www.artic.edu/#organization'], $page['isPartOf']);
        $this->assertStringEndsWith('/departments/3/painting-and-sculpture-of-europe', $page['url']);
    }

    public function test_collection_page_mapper_for_highlight(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubHighlight(), self::definitions()[StubHighlight::class]);
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'CollectionPage');

        $this->assertNotNull($page);
        $this->assertSame('A Closer Look at Nighthawks', $page['name']);
        $this->assertSame('Explore Edward Hopper\'s iconic painting.', $page['description']);
        $this->assertStringEndsWith('/highlights/11/a-closer-look-at-nighthawks', $page['url']);
    }

    public function test_video_object_mapper(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubVideo(), self::definitions()[StubVideo::class]);
        $script = $manager->renderGraphScript();
        $video = $this->findEntity($this->extractGraph($script), 'VideoObject');

        $this->assertNotNull($video);
        $this->assertSame('Inside the Studio', $video['name']);
        $this->assertSame('PT185S', $video['duration']);
        $this->assertSame('https://youtube.com/watch?v=abc123', $video['contentUrl']);
        $this->assertSame('https://www.youtube.com/embed/abc123', $video['embedUrl']);
        $this->assertSame('https://img.youtube.com/vi/abc123/hqdefault.jpg', $video['thumbnailUrl']);
        $this->assertStringContainsString('Welcome to the studio. This is the transcript.', $script);
        $this->assertStringContainsString('"uploadDate":"2024-02-10T12:00:00', $script);
        $this->assertStringEndsWith('/videos/21/inside-the-studio', $video['url']);
    }

    public function test_video_object_mapper_uses_shorts_route(): void
    {
        $manager = new JsonLdManager();

        $stub = new StubVideo();
        $stub->is_short = true;
        $stub->is_captioned = false;

        $manager->addModelEntity($stub, self::definitions()[StubVideo::class]);
        $video = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'VideoObject');

        $this->assertNotNull($video);
        $this->assertStringEndsWith('/videos/shorts/21', $video['url']);
        $this->assertArrayNotHasKey('transcript', $video);
    }

    public function test_playlist_mapper_builds_item_list(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubPlaylist(), self::definitions()[StubPlaylist::class]);
        $list = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'ItemList');

        $this->assertNotNull($list);
        $this->assertSame('Artist Talks', $list['name']);
        $this->assertCount(2, $list['itemListElement']);
        $this->assertSame(1, $list['itemListElement'][0]['position']);
        $this->assertSame('Inside the Studio', $list['itemListElement'][0]['item']['name']);
        $this->assertSame('VideoObject', $list['itemListElement'][0]['item']['@type']);
        $this->assertSame('A Second Talk', $list['itemListElement'][1]['item']['name']);
    }

    public function test_publication_issue_mapper(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubMagazineIssue(), self::definitions()[StubMagazineIssue::class]);
        $issue = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'PublicationIssue');

        $this->assertNotNull($issue);
        $this->assertSame('Fall 2024', $issue['name']);
        $this->assertSame('2024-09-01', substr($issue['datePublished'], 0, 10));
        $this->assertSame('Art Institute of Chicago magazine', $issue['isPartOf']['name']);
        $this->assertSame('Periodical', $issue['isPartOf']['@type']);
        $this->assertStringEndsWith('/magazine/issues/41/fall-2024', $issue['url']);
    }

    public function test_book_mapper_for_printed_publication(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubPrintedPublication(), self::definitions()[StubPrintedPublication::class]);
        $book = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Book');

        $this->assertNotNull($book);
        $this->assertSame('Book', $book['@type']);
        $this->assertSame('Van Gogh: The Complete Works', $book['name']);
        $this->assertSame('978-0-86559-000-0', $book['isbn']);
        $this->assertSame('320', $book['numberOfPages']);
        $this->assertSame('2023-11-15', substr($book['datePublished'], 0, 10));
        $this->assertStringEndsWith('/print-publications/51/van-gogh-the-complete-works', $book['url']);
    }

    public function test_book_mapper_for_digital_publication(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubDigitalPublication(), self::definitions()[StubDigitalPublication::class]);
        $book = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Book');

        $this->assertNotNull($book);
        $this->assertSame(['Book', 'DigitalDocument'], $book['@type']);
        $this->assertSame('text/html', $book['encodingFormat']);
        $this->assertSame('Impressionism and Beyond', $book['name']);
        $this->assertStringEndsWith('/digital-publications/61/impressionism-and-beyond', $book['url']);
        $this->assertSame($book['url'], $book['@id']);
    }

    public function test_publication_article_mapper_reuses_article_and_links_book(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubDigitalPublicationArticle(), self::definitions()[StubDigitalPublicationArticle::class]);
        $article = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'Article');

        $this->assertNotNull($article);
        $this->assertSame('Monet in the Garden', $article['headline']);
        $this->assertSame('How Monet composed his garden paintings.', $article['description']);
        $this->assertSame('Jane Doe', $article['author'][0]['name']);
        $this->assertSame('Book', $article['isPartOf']['@type']);
        $this->assertStringEndsWith('/digital-publications/61/impressionism-and-beyond', $article['isPartOf']['@id']);
        $this->assertStringContainsString('/digital-publications/61/impressionism-and-beyond/71/monet-in-the-garden', $article['url']);
    }

    public function test_learning_resource_mapper(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubEducatorResource(), self::definitions()[StubEducatorResource::class]);
        $resource = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'LearningResource');

        $this->assertNotNull($resource);
        $this->assertSame('The Language of Color', $resource['name']);
        $this->assertSame('High School', $resource['educationalLevel']);
        $this->assertSame('Lesson Plan', $resource['learningResourceType']);
        $this->assertStringEndsWith('/educator-resources/81/the-language-of-color', $resource['url']);
    }

    public function test_web_application_mapper_for_experience(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubExperience(), self::definitions()[StubExperience::class]);
        $app = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebApplication');

        $this->assertNotNull($app);
        $this->assertSame('The Thread in the Labyrinth', $app['name']);
        $this->assertSame('An interactive feature about the Thorne Miniature Rooms.', $app['description']);
        $this->assertSame('MultimediaApplication', $app['applicationCategory']);
        $this->assertStringEndsWith('/interactive-features/the-thread-in-the-labyrinth', $app['url']);
    }

    public function test_tourist_trip_mapper_builds_itinerary(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubMyMuseumTour(), self::definitions()[StubMyMuseumTour::class]);
        $tour = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'TouristTrip');

        $this->assertNotNull($tour);
        $this->assertSame('My Afternoon at the Museum', $tour['name']);
        $this->assertSame('Art lover', $tour['touristType']);
        $this->assertSame('ItemList', $tour['itinerary']['@type']);
        $this->assertCount(2, $tour['itinerary']['itemListElement']);
        $this->assertSame('Water Lilies', $tour['itinerary']['itemListElement'][0]['item']['name']);
        $this->assertSame('Claude Monet', $tour['itinerary']['itemListElement'][0]['item']['creator'][0]['name']);
        $this->assertSame('https://www.artic.edu/iiif/2/monet-waterlilies/full/843,/0/default.jpg', $tour['itinerary']['itemListElement'][0]['item']['image']);
        $this->assertStringEndsWith('/my-museum-tour/101', $tour['url']);
    }

    public function test_web_page_mapper_for_generic_page(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubGenericPage(), self::definitions()[StubGenericPage::class]);
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebPage');

        $this->assertNotNull($page);
        $this->assertSame('Visit with My Students', $page['name']);
        $this->assertSame('Plan your school visit.', $page['description']);
        $this->assertSame('2024-03-05', substr($page['dateModified'], 0, 10));
        $this->assertSame(['@id' => 'https://www.artic.edu/#website'], $page['isPartOf']);
        $this->assertStringEndsWith('/visit/visit-with-my-students', $page['url']);
    }

    public function test_web_page_mapper_for_digital_explorer(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubDigitalExplorer(), self::definitions()[StubDigitalExplorer::class]);
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebPage');

        $this->assertNotNull($page);
        $this->assertSame('The Giltwood Table', $page['name']);
        $this->assertStringEndsWith('/digital-explorers/131/the-giltwood-table', $page['url']);
    }

    public function test_web_page_mapper_for_landing_page(): void
    {
        $manager = new JsonLdManager();

        $manager->addModelEntity(new StubLandingPage(), self::definitions()[StubLandingPage::class]);
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebPage');

        $this->assertNotNull($page);
        $this->assertSame('Visit', $page['name']);
        $this->assertSame(['@id' => 'https://www.artic.edu/#website'], $page['isPartOf']);
        $this->assertSame('http://localhost', $page['url']);
    }

    public function test_base_definition_alone_resolves_to_web_page_entity(): void
    {
        $manager = new JsonLdManager();

        // The definition is the shared FrontController base template only, with
        // no child override, so the model must still resolve to a WebPage that
        // carries the shared page properties.
        $manager->addModelEntity(new StubWebPage(), self::definitions()[StubWebPage::class]);
        $page = $this->findEntity($this->extractGraph($manager->renderGraphScript()), 'WebPage');

        $this->assertNotNull($page);
        $this->assertSame('WebPage', $page['@type']);
        $this->assertSame('Plan Your Visit', $page['name']);
        $this->assertSame('Everything you need to know before you arrive.', $page['description']);
        $this->assertSame('en', $page['inLanguage']);
        $this->assertSame(['@id' => 'https://www.artic.edu/#website'], $page['isPartOf']);
        $this->assertSame('http://localhost', $page['url']);
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

    public function test_push_museum_entity_duplicates_global_organization_shape(): void
    {
        $manager = new JsonLdManager();

        $manager->addMuseumEntity();
        $graph = $this->extractGraph($manager->renderGraphScript());

        $organizations = array_filter(
            $graph,
            static fn (array $entity) => in_array('Museum', (array) ($entity['@type'] ?? []), true)
        );

        $this->assertCount(2, $organizations);

        $museum = array_values($organizations)[1];
        $this->assertSame(['Museum', 'Organization'], $museum['@type']);
        $this->assertSame('https://www.artic.edu/#organization', $museum['@id']);
        $this->assertSame('Art Institute of Chicago', $museum['name']);
        $this->assertSame('111 S Michigan Ave', $museum['address']['streetAddress']);
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

    /**
     * The schema.org definitions for every stub model, keyed by stub class,
     * mirroring the definitions controllers supply via jsonLdDefinition().
     * Shared value factories come from SchemaMapper so the tests exercise the
     * same definition helpers the controllers use.
     *
     * @return array<class-string, array<string, mixed>>
     */
    private static function definitions(): array
    {
        $organization = SchemaMapper::orgRef();
        $website = SchemaMapper::siteRef();

        // Literal scalar values that are not model attributes.
        $literal = static fn (mixed $value) => static fn () => $value;

        // ISO 8601 dates from a model attribute.
        $iso = static fn (string $key) => SchemaMapper::iso($key);

        // Cleaned (strip-tags, trimmed) text from the first non-null attribute.
        $text = static fn (string ...$keys) => SchemaMapper::text(...$keys);

        // Hero image via imageFront()/imageAsArray().
        $image = static fn () => SchemaMapper::heroImage();

        // Canonical route URL from id + slug.
        $canonical = static fn (string $route, string $slugKey = 'slug') => SchemaMapper::canonical($route, $slugKey);

        // Optional scalar model attribute, string-cast when numeric or non-empty.
        $optionalField = static function (string $field) {
            return static function ($m) use ($field) {
                try {
                    $value = $m->{$field} ?? null;
                } catch (\Throwable $e) {
                    return null;
                }

                if (is_numeric($value) || (is_string($value) && $value !== '')) {
                    return (string) $value;
                }

                return null;
            };
        };

        // URL for a publication detail page from id + getSlug().
        $publicationUrl = static function (string $routeName) {
            return static function ($m) use ($routeName) {
                if (empty($m->id)) {
                    return null;
                }

                $slug = method_exists($m, 'getSlug') ? $m->getSlug() : null;

                try {
                    return route($routeName, ['id' => $m->id, 'slug' => $slug]);
                } catch (\Throwable $e) {
                    return null;
                }
            };
        };

        $digitalPublicationUrl = $publicationUrl('collection.publications.digital-publications.show');

        $toSeconds = static fn (\DateInterval $interval): int => (($interval->d * 24 + $interval->h) * 60 + $interval->i) * 60 + $interval->s;

        $fromSeconds = static function (int $seconds): string {
            $hours = intdiv($seconds, 3600);
            $minutes = intdiv($seconds % 3600, 60);
            $remainingSeconds = $seconds % 60;

            $time = ($hours > 0 ? $hours . 'H' : '') . ($minutes > 0 ? $minutes . 'M' : '') . ($remainingSeconds > 0 ? $remainingSeconds . 'S' : '');

            return 'PT' . ($time !== '' ? $time : '0S');
        };

        $formatDuration = static function (\DateInterval $interval): string {
            $date = ($interval->y > 0 ? $interval->y . 'Y' : '') . ($interval->m > 0 ? $interval->m . 'M' : '') . ($interval->d > 0 ? $interval->d . 'D' : '');
            $time = ($interval->h > 0 ? $interval->h . 'H' : '') . ($interval->i > 0 ? $interval->i . 'M' : '') . ($interval->s > 0 ? $interval->s . 'S' : '');

            return 'P' . $date . ($date !== '' || $time !== '' ? 'T' : '') . $time;
        };

        $eventDuration = static function ($m) use ($toSeconds, $fromSeconds, $formatDuration): ?string {
            $start = $m->date_start ?? null;
            $end = $m->date_end ?? null;

            if ($start instanceof \DateTimeInterface && $end instanceof \DateTimeInterface) {
                $interval = $start->diff($end);

                return $interval->invert === 0 ? $formatDuration($interval) : null;
            }

            try {
                $startTime = $m->start_time ?? null;
                $endTime = $m->end_time ?? null;
            } catch (\Throwable $e) {
                return null;
            }

            if (!is_string($startTime) || !is_string($endTime) || $startTime === '' || $endTime === '') {
                return null;
            }

            try {
                $seconds = $toSeconds(new \DateInterval($endTime)) - $toSeconds(new \DateInterval($startTime));

                if ($seconds <= 0) {
                    return null;
                }

                return $fromSeconds($seconds);
            } catch (\Throwable $e) {
                return null;
            }
        };

        $eventAudience = static function ($m) {
            $labels = [];

            try {
                $primary = $m->audience ?? null;

                if (is_numeric($primary) && isset(Event::$eventAudiences[(int) $primary])) {
                    $labels[] = Event::$eventAudiences[(int) $primary];
                }
            } catch (\Throwable $e) {
                // Ignore accessor failures; fall through to alt audiences
            }

            try {
                $altAudiences = $m->alt_audiences ?? null;

                if (is_array($altAudiences)) {
                    foreach ($altAudiences as $audience) {
                        $id = is_array($audience) ? ($audience['id'] ?? null) : ($audience->id ?? null);

                        if (is_numeric($id) && isset(Event::$eventAudiences[(int) $id])) {
                            $labels[] = Event::$eventAudiences[(int) $id];
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Ignore accessor failures
            }

            $labels = array_values(array_unique(array_filter($labels)));

            if (empty($labels)) {
                return null;
            }

            $audience = array_map(
                static fn (string $label) => ['@type' => 'Audience', 'audienceType' => $label],
                $labels
            );

            return count($audience) === 1 ? $audience[0] : $audience;
        };

        $eventKeywords = static function ($m) {
            $labels = [];

            try {
                $eventType = $m->event_type ?? null;

                if (is_numeric($eventType) && isset(Event::$eventTypes[(int) $eventType])) {
                    $labels[] = Event::$eventTypes[(int) $eventType];
                }
            } catch (\Throwable $e) {
                // Ignore accessor failures
            }

            try {
                $altTypes = $m->alt_types ?? null;

                if (is_array($altTypes)) {
                    foreach ($altTypes as $type) {
                        $id = is_array($type) ? ($type['id'] ?? null) : ($type->id ?? null);

                        if (is_numeric($id) && isset(Event::$eventTypes[(int) $id])) {
                            $labels[] = Event::$eventTypes[(int) $id];
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Ignore accessor failures
            }

            $labels = array_values(array_unique(array_filter($labels)));

            return empty($labels) ? null : implode(', ', $labels);
        };

        $eventLocation = static function ($m, $mapper) {
            if (!empty($m->is_virtual_event)) {
                return [
                    '@type' => 'VirtualLocation',
                    'url' => $m->virtual_event_url ?? null,
                ];
            }

            if (empty($m->location)) {
                return null;
            }

            return [
                '@type' => 'Place',
                'name' => $m->location,
                'address' => $mapper->museumAddress(),
            ];
        };

        $eventOffers = static function ($m) {
            $offer = ['@type' => 'Offer'];

            $url = null;

            if (!empty($m->rsvp_link)) {
                $url = $m->rsvp_link;
            } elseif (!empty($m->is_ticketed)) {
                try {
                    $url = $m->buy_tickets_link ?? null;
                } catch (\Throwable $e) {
                    $url = null;
                }
            }

            if (is_string($url) && $url !== '') {
                $offer['url'] = $url;
            }

            $offer['availability'] = !empty($m->is_sold_out)
                ? 'https://schema.org/SoldOut'
                : 'https://schema.org/InStock';

            if (!empty($m->is_free)) {
                $offer['price'] = '0';
                $offer['priceCurrency'] = 'USD';
            }

            return count($offer) > 1 ? $offer : null;
        };

        $articleAbstract = static function ($m, $mapper) {
            try {
                $abstract = $m->list_description ?? null;
            } catch (\Throwable $e) {
                $abstract = null;
            }

            return $mapper->cleanText($abstract);
        };

        $articleAuthors = static function ($m) {
            $authors = [];

            if (!empty($m->authors)) {
                foreach ($m->authors as $author) {
                    if (empty($author->title)) {
                        continue;
                    }

                    $entry = [
                        '@type' => 'Person',
                        'name' => $author->title,
                    ];

                    $id = $author->id ?? null;

                    if (!empty($id)) {
                        try {
                            $slug = method_exists($author, 'getSlug') ? $author->getSlug() : null;

                            $entry['url'] = route('authors.show', ['id' => $id, 'slug' => $slug]);
                        } catch (\Throwable $e) {
                            // Omit the author URL when the route cannot be resolved
                        }
                    }

                    $authors[] = $entry;
                }
            }

            if (empty($authors) && !empty($m->author_display)) {
                $authors[] = [
                    '@type' => 'Person',
                    'name' => $m->author_display,
                ];
            }

            return empty($authors) ? null : $authors;
        };

        $articleKeywords = static function ($m) {
            try {
                $categories = $m->categories ?? collect();
            } catch (\Throwable $e) {
                $categories = collect();
            }

            if (!($categories instanceof \Traversable)) {
                return null;
            }

            $names = collect($categories)
                ->map(static fn ($category) => is_object($category) ? ($category->name ?? null) : ($category['name'] ?? null))
                ->filter()
                ->unique()
                ->values();

            return $names->isEmpty() ? null : $names->implode(', ');
        };

        $articleDefinition = [
            '@type' => static fn ($m) => ($m->article_type ?? $m->articleType ?? 'article') === 'editorial' ? 'BlogPosting' : 'Article',
            'headline' => 'title',
            'description' => $text('description', 'heading', 'list_description'),
            'abstract' => $articleAbstract,
            'image' => $image(),
            'thumbnailUrl' => static fn ($m, $mapper) => $mapper->thumbnailUrl(),
            'datePublished' => $iso('date'),
            'dateModified' => static fn ($m, $mapper) => $mapper->toIso8601($m->updated_at ?? $m->date ?? null),
            'author' => $articleAuthors,
            'publisher' => $organization,
            'mainEntityOfPage' => $canonical('articles.show'),
            'articleSection' => static fn ($m) => $m->article_type ?? $m->articleType ?? 'article',
            'inLanguage' => $literal('en'),
            'keywords' => $articleKeywords,
        ];

        $publicationArticleUrl = static function ($m) {
            if (empty($m->id)) {
                return null;
            }

            try {
                $publication = $m->digitalPublication ?? null;
            } catch (\Throwable $e) {
                $publication = null;
            }

            $pubId = is_object($publication) ? ($publication->id ?? null) : null;
            $pubSlug = is_object($publication) && method_exists($publication, 'getSlug') ? $publication->getSlug() : null;

            try {
                return route('collection.publications.digital-publications-articles.show', [
                    'pubId' => $pubId,
                    'pubSlug' => $pubSlug,
                    'id' => $m->id,
                    'slug' => method_exists($m, 'getSlug') ? $m->getSlug() : null,
                ]);
            } catch (\Throwable $e) {
                return null;
            }
        };

        $publicationArticleIsPartOf = static function ($m) {
            try {
                $publication = $m->digitalPublication ?? null;
            } catch (\Throwable $e) {
                $publication = null;
            }

            if (!$publication || empty($publication->id)) {
                return null;
            }

            $slug = method_exists($publication, 'getSlug') ? $publication->getSlug() : null;

            try {
                $publicationUrl = route('collection.publications.digital-publications.show', [
                    'id' => $publication->id,
                    'slug' => $slug,
                ]);
            } catch (\Throwable $e) {
                return null;
            }

            return [
                '@type' => 'Book',
                '@id' => $publicationUrl,
                'name' => $publication->title ?? null,
            ];
        };

        $bookAuthor = static function ($m) {
            try {
                $author = $m->author ?? null;
            } catch (\Throwable $e) {
                $author = null;
            }

            return is_string($author) && $author !== '' ? $author : null;
        };

        $bookDatePublished = static function ($m, $mapper) {
            $date = $m->publication_date ?? $m->publish_start_date ?? null;

            return $mapper->toIso8601($date);
        };

        $videoUrl = static function ($m) {
            if (empty($m->id)) {
                return null;
            }

            $slug = method_exists($m, 'getSlug') ? $m->getSlug() : null;

            try {
                if (!empty($m->is_short)) {
                    return route('shorts.show', ['video' => $m->id]);
                }

                return route('videos.show', ['video' => $m->id, 'slug' => $slug]);
            } catch (\Throwable $e) {
                return null;
            }
        };

        $videoThumbnail = static function ($m, $mapper) {
            try {
                $thumbnail = $m->thumbnail_url ?? null;
            } catch (\Throwable $e) {
                $thumbnail = null;
            }

            if (is_string($thumbnail) && str_starts_with($thumbnail, 'http')) {
                return $thumbnail;
            }

            return $mapper->imageUrl();
        };

        $videoDuration = static function ($m) {
            $duration = $m->duration ?? null;

            if (!is_numeric($duration) || (int) $duration <= 0) {
                return null;
            }

            return 'PT' . (int) $duration . 'S';
        };

        $videoTranscript = static function ($m) {
            if (empty($m->is_captioned)) {
                return null;
            }

            try {
                $caption = $m->standardCaption;
            } catch (\Throwable $e) {
                return null;
            }

            if (!$caption) {
                return null;
            }

            try {
                $transcript = $caption->transcript;
            } catch (\Throwable $e) {
                return null;
            }

            if (is_string($transcript) && trim($transcript) !== '') {
                return trim($transcript);
            }

            return null;
        };

        $videoDefinition = [
            '@type' => 'VideoObject',
            'name' => 'title',
            'description' => $text('list_description', 'heading', 'description'),
            'thumbnailUrl' => $videoThumbnail,
            'uploadDate' => $iso('uploaded_at'),
            'duration' => $videoDuration,
            'contentUrl' => 'video_url',
            'embedUrl' => 'embed_url',
            'url' => $videoUrl,
            'mainEntityOfPage' => $videoUrl,
            'publisher' => $organization,
            'inLanguage' => $literal('en'),
            'transcript' => $videoTranscript,
        ];

        $playlistUrl = static function ($m) {
            if (empty($m->id)) {
                return null;
            }

            try {
                return route('playlists.show', ['playlist' => $m->id]);
            } catch (\Throwable $e) {
                return null;
            }
        };

        $playlistItems = static function ($m, $mapper) use ($videoDefinition) {
            try {
                $videos = $m->videos ?? collect();
            } catch (\Throwable $e) {
                $videos = collect();
            }

            if (!$videos instanceof \Traversable) {
                return null;
            }

            $elements = [];
            $position = 1;

            foreach ($videos as $video) {
                $entity = $mapper->mapWith($video, $videoDefinition);

                if (empty($entity['name'])) {
                    continue;
                }

                $pivotPosition = is_object($video) && isset($video->pivot)
                    ? ($video->pivot->position ?? null)
                    : null;

                $elements[] = [
                    '@type' => 'ListItem',
                    'position' => is_numeric($pivotPosition) ? (int) $pivotPosition : $position,
                    'item' => $entity,
                ];

                $position++;
            }

            return empty($elements) ? null : $elements;
        };

        $resourceCategories = static function (string $type) {
            return static function ($m) use ($type) {
                try {
                    $categories = $m->categories ?? collect();
                } catch (\Throwable $e) {
                    $categories = collect();
                }

                if (!$categories instanceof \Traversable) {
                    return null;
                }

                $labels = [];

                foreach ($categories as $category) {
                    $name = is_object($category) ? ($category->name ?? null) : ($category['name'] ?? null);
                    $categoryType = is_object($category) ? ($category->type ?? null) : ($category['type'] ?? null);

                    if (!is_string($name) || $name === '' || $categoryType !== $type) {
                        continue;
                    }

                    $labels[] = $name;
                }

                $labels = array_values(array_unique($labels));

                if (empty($labels)) {
                    return null;
                }

                return count($labels) === 1 ? $labels[0] : $labels;
            };
        };

        $experienceUrl = static function ($m) {
            if (method_exists($m, 'getSlug') && $m->getSlug() !== '') {
                try {
                    return route('interactiveFeatures.show', ['slug' => $m->getSlug()]);
                } catch (\Throwable $e) {
                    return null;
                }
            }

            try {
                $slug = $m->slug ?? null;
            } catch (\Throwable $e) {
                $slug = null;
            }

            if (!is_string($slug) || $slug === '') {
                return null;
            }

            try {
                return route('interactiveFeatures.show', ['slug' => $slug]);
            } catch (\Throwable $e) {
                return null;
            }
        };

        $tourDescription = static function ($m, $mapper) {
            $tour = is_array($m->tour_json ?? null) ? $m->tour_json : [];

            foreach (['description', 'short_description', 'intro'] as $key) {
                $value = $tour[$key] ?? null;

                if (is_string($value) && trim(strip_tags($value)) !== '') {
                    return trim(strip_tags($value));
                }
            }

            return null;
        };

        $tourUrl = static function ($m) {
            $id = $m->id ?? null;

            if (empty($id)) {
                return null;
            }

            try {
                return route('my-museum-tour.show', ['id' => $id]);
            } catch (\Throwable $e) {
                return null;
            }
        };

        $tourArtworkEntity = static function (array $artwork) {
            $title = $artwork['title'] ?? null;

            if (!is_string($title) || $title === '') {
                return null;
            }

            $entity = [
                '@type' => 'VisualArtwork',
                'name' => $title,
            ];

            if (is_string($artwork['artist_title'] ?? null) && $artwork['artist_title'] !== '') {
                $entity['creator'] = [
                    [
                        '@type' => 'Person',
                        'name' => $artwork['artist_title'],
                    ],
                ];
            }

            if (is_string($artwork['display_date'] ?? null) && $artwork['display_date'] !== '') {
                $entity['dateCreated'] = $artwork['display_date'];
            }

            if (is_string($artwork['description'] ?? null) && trim($artwork['description']) !== '') {
                $entity['description'] = trim($artwork['description']);
            }

            $id = $artwork['id'] ?? null;

            if (!empty($id)) {
                $slug = StringHelpers::getUtf8Slug((string) ($artwork['title'] ?? ''));

                try {
                    $entity['url'] = route('artworks.show', ['id' => $id, 'slug' => $slug]);
                } catch (\Throwable $e) {
                    // Omit the artwork URL when the route cannot be resolved
                }
            }

            $imageId = $artwork['image_id'] ?? null;

            if (is_string($imageId) && $imageId !== '') {
                $entity['image'] = 'https://www.artic.edu/iiif/2/' . $imageId . '/full/843,/0/default.jpg';
            }

            return $entity;
        };

        $tourItinerary = static function ($m) use ($tourArtworkEntity) {
            $tour = is_array($m->tour_json ?? null) ? $m->tour_json : [];
            $artworks = $tour['artworks'] ?? [];

            if (!is_array($artworks) || empty($artworks)) {
                return null;
            }

            $elements = [];
            $position = 1;

            foreach ($artworks as $artwork) {
                if (!is_array($artwork)) {
                    continue;
                }

                $entity = $tourArtworkEntity($artwork);

                if ($entity === null) {
                    continue;
                }

                $elements[] = [
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'item' => $entity,
                ];
            }

            if (empty($elements)) {
                return null;
            }

            return [
                '@type' => 'ItemList',
                'itemListElement' => $elements,
            ];
        };

        $genericPageUrl = static function ($m) {
            try {
                $url = $m->url ?? null;
            } catch (\Throwable $e) {
                $url = null;
            }

            if (!is_string($url) || $url === '' || str_starts_with($url, 'http')) {
                return is_string($url) && $url !== '' ? $url : null;
            }

            try {
                return route('pages.slug', ['slug' => ltrim($url, '/')]);
            } catch (\Throwable $e) {
                return url($url);
            }
        };

        $digitalExplorerUrl = static function ($m) {
            if (empty($m->id)) {
                return null;
            }

            $slug = method_exists($m, 'getSlug') ? $m->getSlug() : null;

            try {
                return route('digitalExplorer.show', ['id' => $m->id, 'slug' => $slug]);
            } catch (\Throwable $e) {
                return null;
            }
        };

        $landingPageUrl = static function ($m) {
            $slug = method_exists($m, 'getSlug') ? $m->getSlug() : null;

            if (is_string($slug) && $slug !== '' && $slug !== 'home') {
                try {
                    return route('pages.slug', ['slug' => $slug]);
                } catch (\Throwable $e) {
                    // Fall through to the home route
                }
            }

            try {
                return route('home');
            } catch (\Throwable $e) {
                return null;
            }
        };

        $artistIsCorporate = static fn ($m): bool => empty($m->birth_date) && empty($m->death_date);

        $artworkDimensions = static function ($m) {
            try {
                $details = $m->dimensions_detail ?? null;
            } catch (\Throwable $e) {
                $details = null;
            }

            if (!is_array($details) || empty($details)) {
                return null;
            }

            foreach ($details as $detail) {
                $detail = is_array($detail) ? $detail : (array) $detail;

                $unitCode = match (strtolower((string) ($detail['unit'] ?? ''))) {
                    'cm' => 'CMT',
                    'in' => 'INH',
                    default => null,
                };

                $dimensions = [];

                foreach (['width', 'height', 'depth'] as $key) {
                    $value = $detail[$key] ?? null;

                    if (!is_numeric($value)) {
                        continue;
                    }

                    $quantitativeValue = [
                        '@type' => 'QuantitativeValue',
                        'value' => (float) $value,
                    ];

                    if ($unitCode !== null) {
                        $quantitativeValue['unitCode'] = $unitCode;
                    }

                    $dimensions[$key] = $quantitativeValue;
                }

                if (!empty($dimensions)) {
                    return $dimensions;
                }
            }

            return null;
        };

        $quantitativeValue = static function (string $key) use ($artworkDimensions) {
            return static fn ($m) => ($artworkDimensions($m) ?? [])[$key] ?? null;
        };

        // Agents with recorded life dates are people; dateless agents are
        // cultures, workshops, or other groups. Schema.org has no Culture
        // type, so groups are typed as Organization with an additionalType
        // URI from ULAN (agent-specific) or Getty AAT (generic cultures).
        $creators = static function ($m) {
            try {
                $artists = $m->artists ?? null;
            } catch (\Throwable $e) {
                $artists = null;
            }

            $nodes = [];

            if ($artists) {
                foreach ($artists as $artist) {
                    $name = $artist->title ?? null;

                    if (empty($name)) {
                        continue;
                    }

                    if (!empty($artist->birth_date) || !empty($artist->death_date)) {
                        $nodes[] = ['@type' => 'Person', 'name' => $name];
                        continue;
                    }

                    $node = ['@type' => 'Organization', 'name' => $name];
                    $node['additionalType'] = !empty($artist->ulan_id)
                        ? 'https://vocab.getty.edu/ulan/' . $artist->ulan_id
                        : 'http://vocab.getty.edu/aat/300387177';
                    $nodes[] = $node;
                }
            }

            if (empty($nodes)) {
                try {
                    $artistTitle = $m->artist_title ?? null;
                } catch (\Throwable $e) {
                    $artistTitle = null;
                }

                if (empty($artistTitle)) {
                    return null;
                }

                $nodes[] = ['@type' => 'Person', 'name' => $artistTitle];
            }

            return $nodes;
        };

        // Shared WebPage defaults, mirroring FrontController::jsonLdDefinition().
        // Controllers merge these under their page-specific definitions; a model
        // mapped with only this definition still resolves to a plain WebPage.
        $baseDefinition = [
            '@type' => 'WebPage',
            'name' => static fn ($m) => $m->title ?? $m->name ?? null,
            'description' => $text('description', 'list_description'),
            'image' => $image(),
            'url' => static fn () => url()->current(),
            'isPartOf' => $website,
            'inLanguage' => $literal('en'),
        ];

        return [
            StubArtwork::class => [
                '@type' => 'VisualArtwork',
                'name' => 'title',
                'alternateName' => 'main_reference_number',
                'dateCreated' => 'date_display',
                'artMedium' => 'medium_display',
                'size' => 'dimensions',
                'artform' => 'artwork_type_title',
                'image' => $image(),
                'locationCreated' => 'place_of_origin',
                'displayLocation' => static fn ($m) => $m->gallery_title ?? null,
                'creditText' => 'credit_line',
                'url' => $canonical('artworks.show', 'titleSlug'),
                'mainEntityOfPage' => $canonical('artworks.show', 'titleSlug'),
                'inLanguage' => $literal('en'),
                'thumbnailUrl' => static fn ($m, $mapper) => $mapper->thumbnailUrl(),
                'description' => $text('description'),
                'identifier' => static function ($m) {
                    try {
                        $number = $m->main_reference_number ?? null;
                    } catch (\Throwable $e) {
                        $number = null;
                    }

                    if (!is_string($number) || $number === '') {
                        return null;
                    }

                    return [
                        '@type' => 'PropertyValue',
                        'propertyID' => 'main_reference_number',
                        'value' => $number,
                    ];
                },
                'artist' => $creators,
                'width' => $quantitativeValue('width'),
                'height' => $quantitativeValue('height'),
                'depth' => $quantitativeValue('depth'),
                'copyrightNotice' => 'copyright_notice',
                'license' => 'license',
                'keywords' => static function ($m) {
                    $keywords = [];

                    foreach (['subject_titles', 'style_titles', 'category_titles'] as $field) {
                        try {
                            $values = $m->{$field} ?? null;
                        } catch (\Throwable $e) {
                            $values = null;
                        }

                        if (!is_array($values)) {
                            continue;
                        }

                        foreach ($values as $value) {
                            if (is_string($value) && $value !== '') {
                                $keywords[] = $value;
                            }
                        }
                    }

                    $keywords = array_values(array_unique($keywords));

                    return empty($keywords) ? null : implode(', ', $keywords);
                },
                'genre' => static function ($m) {
                    try {
                        $genre = $m->classification_title ?? null;

                        if (empty($genre)) {
                            $titles = $m->classification_titles ?? null;
                            $genre = is_array($titles) ? ($titles[0] ?? null) : null;
                        }
                    } catch (\Throwable $e) {
                        $genre = null;
                    }

                    return is_string($genre) && $genre !== '' ? $genre : null;
                },
                'isPartOf' => static function ($m) {
                    try {
                        $department = $m->department_title ?? null;
                    } catch (\Throwable $e) {
                        $department = null;
                    }

                    if (!is_string($department) || $department === '') {
                        return null;
                    }

                    return [
                        '@type' => 'Collection',
                        'name' => $department,
                    ];
                },
                'encoding' => static function ($m) {
                    try {
                        $id = $m->id ?? null;
                    } catch (\Throwable $e) {
                        $id = null;
                    }

                    if (empty($id)) {
                        return null;
                    }

                    return [
                        '@type' => 'DigitalDocument',
                        '@id' => 'https://api.artic.edu/api/v1/artworks/' . $id . '/manifest.json',
                        'encodingFormat' => 'application/ld+json',
                    ];
                },
                'creator' => $creators,
                'sameAs' => static function ($m) {
                    try {
                        $id = $m->id ?? null;
                    } catch (\Throwable $e) {
                        $id = null;
                    }

                    if (empty($id)) {
                        return null;
                    }

                    return 'https://api.artic.edu/api/v1/artworks/' . $id;
                },
            ],

            StubExhibition::class => [
                '@type' => 'ExhibitionEvent',
                'name' => 'title',
                'description' => $text('list_description', 'description'),
                'startDate' => $iso('date_start'),
                'endDate' => $iso('date_end'),
                'image' => $image(),
                'eventStatus' => $literal('https://schema.org/EventScheduled'),
                'eventAttendanceMode' => $literal('https://schema.org/OfflineEventAttendanceMode'),
                'url' => $canonical('exhibitions.show', 'titleSlug'),
                'organizer' => $organization,
                'inLanguage' => $literal('en'),
                'location' => static function ($m, $mapper) {
                    try {
                        $gallery = $m->gallery_title ?? null;
                    } catch (\Throwable $e) {
                        $gallery = null;
                    }

                    if (empty($gallery)) {
                        return null;
                    }

                    return [
                        '@type' => 'Place',
                        'name' => $gallery,
                        'address' => $mapper->museumAddress(),
                        'containedInPlace' => ['@id' => 'https://www.artic.edu/#organization'],
                    ];
                },
            ],

            StubEvent::class => [
                '@type' => 'Event',
                'name' => 'title',
                'description' => $text('short_description', 'list_description'),
                'startDate' => $iso('date_start'),
                'endDate' => $iso('date_end'),
                'doorTime' => 'door_time',
                'duration' => $eventDuration,
                'image' => $image(),
                'eventStatus' => $literal('https://schema.org/EventScheduled'),
                'isAccessibleForFree' => static fn ($m) => !empty($m->is_free) ? true : null,
                'eventAttendanceMode' => static fn ($m) => !empty($m->is_virtual_event)
                    ? 'https://schema.org/OnlineEventAttendanceMode'
                    : 'https://schema.org/OfflineEventAttendanceMode',
                'url' => $canonical('events.show'),
                'organizer' => $organization,
                'inLanguage' => $literal('en'),
                'audience' => $eventAudience,
                'keywords' => $eventKeywords,
                'location' => $eventLocation,
                'offers' => $eventOffers,
            ],

            StubArticle::class => $articleDefinition,

            StubAuthor::class => [
                '@type' => 'Person',
                'name' => 'title',
                'description' => $text('description', 'list_description'),
                'image' => $image(),
                'url' => $canonical('authors.show'),
                'mainEntityOfPage' => $canonical('authors.show'),
                'inLanguage' => $literal('en'),
                'jobTitle' => 'job_title',
            ],

            StubArtist::class => [
                '@type' => static fn ($m) => $artistIsCorporate($m) ? 'Organization' : 'Person',
                'name' => 'title',
                'description' => $text('description'),
                'image' => $image(),
                'url' => $canonical('artists.show', 'titleSlug'),
                'mainEntityOfPage' => $canonical('artists.show', 'titleSlug'),
                'inLanguage' => $literal('en'),
                'additionalType' => static fn ($m) => $artistIsCorporate($m) && !empty($m->ulan_id)
                    ? 'https://vocab.getty.edu/ulan/' . $m->ulan_id
                    : null,
                'birthDate' => static fn ($m) => $artistIsCorporate($m) ? null : ($m->birth_date ?? null),
                'deathDate' => static fn ($m) => $artistIsCorporate($m) ? null : ($m->death_date ?? null),
                'birthPlace' => static fn ($m) => $artistIsCorporate($m) ? null : ($m->birth_place ?? null),
                'nationality' => static fn ($m) => $artistIsCorporate($m) ? null : ($m->nationality ?? null),
            ],

            StubGallery::class => [
                '@type' => 'Place',
                'name' => 'title',
                'description' => $text('description'),
                'url' => $canonical('galleries.show', 'titleSlug'),
                'containedInPlace' => $organization,
                'geo' => static function ($m) {
                    try {
                        $latitude = $m->latitude ?? null;
                        $longitude = $m->longitude ?? null;
                    } catch (\Throwable $e) {
                        return null;
                    }

                    if (!is_numeric($latitude) || !is_numeric($longitude)) {
                        return null;
                    }

                    return [
                        '@type' => 'GeoCoordinates',
                        'latitude' => (float) $latitude,
                        'longitude' => (float) $longitude,
                    ];
                },
            ],

            StubDepartment::class => [
                '@type' => 'CollectionPage',
                'name' => 'title',
                'description' => $text('description', 'short_copy', 'list_description'),
                'inLanguage' => $literal('en'),
                'url' => $canonical('departments.show', 'titleSlug'),
                'mainEntityOfPage' => $canonical('departments.show', 'titleSlug'),
                'isPartOf' => $organization,
            ],

            StubHighlight::class => [
                '@type' => 'CollectionPage',
                'name' => 'title',
                'description' => $text('description', 'short_copy', 'list_description'),
                'inLanguage' => $literal('en'),
                'url' => $canonical('highlights.show'),
                'mainEntityOfPage' => $canonical('highlights.show'),
            ],

            StubVideo::class => $videoDefinition,

            StubPlaylist::class => [
                '@type' => 'ItemList',
                'name' => 'title',
                'description' => $text('description', 'list_description'),
                'url' => $playlistUrl,
                'itemListElement' => $playlistItems,
            ],

            StubMagazineIssue::class => [
                '@type' => 'PublicationIssue',
                'name' => 'title',
                'description' => $text('list_description', 'description'),
                'datePublished' => $iso('publish_start_date'),
                'image' => $image(),
                'url' => $canonical('magazine-issues.show'),
                'mainEntityOfPage' => $canonical('magazine-issues.show'),
                'isPartOf' => [
                    '@type' => 'Periodical',
                    'name' => 'Art Institute of Chicago magazine',
                ],
                'issueNumber' => $optionalField('issue_number'),
            ],

            StubPrintedPublication::class => [
                '@type' => 'Book',
                'name' => 'title',
                'image' => $image(),
                'publisher' => $organization,
                'inLanguage' => $literal('en'),
                'author' => $bookAuthor,
                'datePublished' => $bookDatePublished,
                'isbn' => $optionalField('isbn'),
                'numberOfPages' => $optionalField('number_of_pages'),
                'url' => $publicationUrl('collection.publications.printed-publications.show'),
                'mainEntityOfPage' => $publicationUrl('collection.publications.printed-publications.show'),
            ],

            StubDigitalPublication::class => [
                '@type' => ['Book', 'DigitalDocument'],
                'name' => 'title',
                'image' => $image(),
                'publisher' => $organization,
                'inLanguage' => $literal('en'),
                'author' => $bookAuthor,
                'datePublished' => $bookDatePublished,
                'isbn' => $optionalField('isbn'),
                'numberOfPages' => $optionalField('number_of_pages'),
                'url' => $digitalPublicationUrl,
                'mainEntityOfPage' => $digitalPublicationUrl,
                'encodingFormat' => $literal('text/html'),
                '@id' => static function ($m) use ($digitalPublicationUrl) {
                    $url = $digitalPublicationUrl($m);

                    return is_string($url) && $url !== '' ? $url : null;
                },
            ],

            StubDigitalPublicationArticle::class => array_merge($articleDefinition, [
                'url' => $publicationArticleUrl,
                'mainEntityOfPage' => $publicationArticleUrl,
                'articleSection' => static function ($m) {
                    $value = $m->article_type ?? $m->articleType ?? 'article';

                    return $value instanceof \BackedEnum ? (string) $value->value : $value;
                },
                'isPartOf' => $publicationArticleIsPartOf,
            ]),

            StubEducatorResource::class => [
                '@type' => 'LearningResource',
                'name' => 'title',
                'description' => $text('short_description', 'listing_description', 'description'),
                'image' => $image(),
                'url' => $canonical('collection.resources.educator-resources.show'),
                'mainEntityOfPage' => $canonical('collection.resources.educator-resources.show'),
                'inLanguage' => $literal('en'),
                'educationalLevel' => $resourceCategories('audience'),
                'learningResourceType' => $resourceCategories('content'),
            ],

            StubExperience::class => [
                '@type' => 'WebApplication',
                'name' => 'title',
                'description' => $text('listing_description', 'subtitle', 'description'),
                'image' => $image(),
                'url' => $experienceUrl,
                'mainEntityOfPage' => $experienceUrl,
                'applicationCategory' => $literal('MultimediaApplication'),
                'inLanguage' => $literal('en'),
            ],

            StubMyMuseumTour::class => [
                '@type' => 'TouristTrip',
                'name' => static fn ($m) => is_array($m->tour_json ?? null) ? ($m->tour_json['title'] ?? null) : null,
                'description' => $tourDescription,
                'url' => $tourUrl,
                'itinerary' => $tourItinerary,
                'touristType' => static fn ($m) => is_array($m->tour_json ?? null) ? ($m->tour_json['touristType'] ?? $m->tour_json['tourist_type'] ?? null) : null,
            ],

            StubGenericPage::class => [
                '@type' => 'WebPage',
                'name' => 'title',
                'description' => $text('meta_description', 'short_description', 'listing_description', 'description'),
                'image' => $image(),
                'dateModified' => $iso('updated_at'),
                'url' => $genericPageUrl,
                'mainEntityOfPage' => $genericPageUrl,
                'isPartOf' => $website,
                'inLanguage' => $literal('en'),
            ],

            StubDigitalExplorer::class => [
                '@type' => 'WebPage',
                'name' => 'title',
                'description' => $text('meta_description', 'short_description', 'listing_description', 'description'),
                'image' => $image(),
                'dateModified' => $iso('updated_at'),
                'url' => $digitalExplorerUrl,
                'mainEntityOfPage' => $digitalExplorerUrl,
                'isPartOf' => $website,
                'inLanguage' => $literal('en'),
            ],

            StubLandingPage::class => [
                '@type' => 'WebPage',
                'name' => 'title',
                'description' => $text('meta_description', 'short_description', 'listing_description', 'description'),
                'image' => $image(),
                'dateModified' => $iso('updated_at'),
                'url' => $landingPageUrl,
                'mainEntityOfPage' => $landingPageUrl,
                'isPartOf' => $website,
                'inLanguage' => $literal('en'),
            ],

            StubWebPage::class => $baseDefinition,
        ];
    }
}
