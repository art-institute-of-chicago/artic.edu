<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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

        $baseUrl = config('aic.protocol') . '://' . config('app.url');
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
}
