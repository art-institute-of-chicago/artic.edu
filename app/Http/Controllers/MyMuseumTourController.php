<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Helpers\StringHelpers;
use App\Models\MyMuseumTour;
use App\Repositories\LandingPageRepository;
use App\Libraries\MyMuseumTour\ArtworkSortingService;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QROutputInterface;

class MyMuseumTourController extends FrontController
{
    protected $landingPageRepository;

    public function __construct(LandingPageRepository $landingPageRepository)
    {
        $this->landingPageRepository = $landingPageRepository;

        parent::__construct();
    }

    public function show(Request $request, $id)
    {
        $myMuseumTour = MyMuseumTour::findOrFail($id);

        $myMuseumTourJson = $myMuseumTour->tour_json;

        ArtworkSortingService::sortArtworksByGallery($myMuseumTourJson['artworks'], config('galleries.order'));

        $this->seo->setTitle($myMuseumTourJson['title']);
        View::share('globalSuffix', 'My Museum Tour');

        $this->seo->setDescription('View this one-of-a-kind self-guided tour through The Art Institute of Chicago. Available on mobile or download to print and share with family and friends.');

        $landingPage = $this->landingPageRepository->published()->forSlug('my-museum-tour')->firstOrFail();
        $this->seo->setImage($landingPage->imageFront('header_my_museum_tour_header_image') ?? $landingPage->imageFront('header_my_museum_tour_header_image_mobile'));

        $this->seo->nofollow = true;
        $this->seo->noindex = true;

        // Calculate unique galleries and artists
        $galleryTitles = array_column($myMuseumTourJson['artworks'], 'gallery_title');
        $uniqueGalleryTitles = array_unique($galleryTitles);
        $uniqueGalleriesCount = count($uniqueGalleryTitles);

        $artistNames = array_column($myMuseumTourJson['artworks'], 'artist_title');
        $uniqueArtistNames = array_unique($artistNames);
        $uniqueArtistsCount = count($uniqueArtistNames);

        // Variable to check for tourCreationComplete=true in the URL
        $tourCreationComplete = $request->query('tourCreationComplete') === 'true';

        $landingPage = $this->landingPageRepository->published()->forSlug('my-museum-tour')->firstOrFail();
        $hero_media = $landingPage->imageFront('header_my_museum_tour_header_image');
        $mobile_hero_media = $landingPage->imageFront('header_my_museum_tour_header_image_mobile');

        $this->addJsonLd($myMuseumTour);

        return view('site.myMuseumTour', [
            'item' => $myMuseumTour,
            'my_museum_tour' => $myMuseumTourJson,
            'unique_galleries_count' => $uniqueGalleriesCount,
            'unique_artists_count' => $uniqueArtistsCount,
            'unstickyHeader' => true,
            'tour_creation_completed' => $tourCreationComplete,
            'hero_media' => $hero_media,
            'mobile_hero_media' => $mobile_hero_media,
            'tours_create_cta_module_image' => $landingPage->imageFront('tours_create_cta_module_image'),
            'tours_tickets_cta_module_image' => $landingPage->imageFront('tours_tickets_cta_module_image'),
        ]);
    }

    public function pdfLayout(Request $request, $id)
    {
        $myMuseumTour = MyMuseumTour::findOrFail($id);

        $myMuseumTourJson = $myMuseumTour->tour_json;

        ArtworkSortingService::sortArtworksByGallery($myMuseumTourJson['artworks'], config('galleries.order'));

        // Calculate unique galleries and artists
        $galleryTitles = array_column($myMuseumTourJson['artworks'], 'gallery_title');
        $uniqueGalleryTitles = array_unique($galleryTitles);
        $uniqueGalleriesCount = count($uniqueGalleryTitles);

        $artistNames = array_column($myMuseumTourJson['artworks'], 'artist_title');
        $uniqueArtistNames = array_unique($artistNames);
        $uniqueArtistsCount = count($uniqueArtistNames);

        $landingPage = $this->landingPageRepository->published()->forSlug('my-museum-tour')->firstOrFail();

        return view('site.myMuseumToursPdfLayout', [
            'id' => $myMuseumTour->id,
            'my_museum_tour' => $myMuseumTourJson,
            'unique_galleries_count' => $uniqueGalleriesCount,
            'unique_artists_count' => $uniqueArtistsCount,
            'headerImage' => $landingPage->imageFront('header_my_museum_tour_header_image_pdf')
        ]);
    }

    public function qrcode(Request $request, $id)
    {
        $myMuseumTour = MyMuseumTour::findOrFail($id);

        $baseUrl = config('app.url');
        $fullUrl = $baseUrl . route('my-museum-tour.show', [ 'id' => $myMuseumTour->id ], false);

        $options = new QROptions(
            [
              'eccLevel' => EccLevel::L,
              'outputType' => QROutputInterface::GDIMAGE_PNG,
              'version' => 5,
              'quietzoneSize' => 0,
            ]
        );

        $qrcode = (new QRCode($options))->render($fullUrl);

        $imageData = explode(',', $qrcode)[1];
        $decodedImageData = base64_decode($imageData);
        return response($decodedImageData)
            ->header('Content-Type', 'image/png');
    }

    public function showMyMuseumTourBuilder()
    {
        $landingPage = $this->landingPageRepository->published()->forSlug('my-museum-tour')->firstOrFail();
        $this->seo->setImage($landingPage->imageFront('header_my_museum_tour_header_image') ?? $landingPage->imageFront('header_my_museum_tour_header_image_mobile'));
        $this->seo->setTitle('My Museum Tour');
        $this->seo->setDescription('Create a unique self-guided museum tour with our easy-to-use platform. Choose from popular tours or build your own with up to six artworks. Add a title and notes then view on your phone or in print.');

        return view('site.myMuseumTourBuilder', [
            'unstickyHeader' => true
        ]);
    }

    /**
     * The schema.org definition for the given model.
     *
     * Shared defaults (e.g. inLanguage) come from the parent; page-specific
     * properties defined here are merged over them.
     *
     * @param mixed $model The model to map.
     *
     * @return array<string, mixed>
     */
    protected function jsonLdDefinition(mixed $model): array
    {
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

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => 'TouristTrip',
                'name' => static fn ($m) => is_array($m->tour_json ?? null) ? ($m->tour_json['title'] ?? null) : null,
                'description' => $tourDescription,
                'url' => $tourUrl,
                'itinerary' => $tourItinerary,
                'touristType' => static fn ($m) => is_array($m->tour_json ?? null) ? ($m->tour_json['touristType'] ?? $m->tour_json['tourist_type'] ?? null) : null,
            ]
        );
    }
}
