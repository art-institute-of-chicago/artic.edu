<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyMuseumTour;
use App\Libraries\MyMuseumTour\ArtworkSortingService;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QROutputInterface;

class MyMuseumTourController extends FrontController
{
    public function show(Request $request, $id)
    {
        $myMuseumTour = MyMuseumTour::findOrFail($id);

        $myMuseumTourJson = $myMuseumTour->tour_json;

        ArtworkSortingService::sortArtworksByGallery($myMuseumTourJson['artworks'], config('galleries.order'));

        $this->seo->setTitle($myMuseumTourJson['title']);

        if (array_key_exists('description', $myMuseumTourJson)) {
            $this->seo->setDescription($myMuseumTourJson['description']);
        }

        $this->seo->image = 'https://' . rtrim(config('app.url'), '/') . '/iiif/2/3c27b499-af56-f0d5-93b5-a7f2f1ad5813/full/1200,799/0/default.jpg';
        $this->seo->width = 1200;
        $this->seo->height = 799;
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

        return view('site.myMuseumTour', [
            'id' => $myMuseumTour->id,
            'my_museum_tour' => $myMuseumTourJson,
            'unique_galleries_count' => $uniqueGalleriesCount,
            'unique_artists_count' => $uniqueArtistsCount,
            'unstickyHeader' => true,
            'tour_creation_completed' => $tourCreationComplete
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


        return view('site.myMuseumToursPdfLayout', [
            'id' => $myMuseumTour->id,
            'my_museum_tour' => $myMuseumTourJson,
            'unique_galleries_count' => $uniqueGalleriesCount,
            'unique_artists_count' => $uniqueArtistsCount,
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
        return view('site.myMuseumTourBuilder', [
            'unstickyHeader' => true
        ]);
    }
}
