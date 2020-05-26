@extends('twill::layouts.form')

@section('contentFields')
    @formField('browser', [
        'routePrefix' => 'collection',
        'max' => 1,
        'moduleName' => 'artists',
        'name' => 'artists',
        'label' => 'Artists'
    ])

    <p class="f-note">If no image is selected, we will fall back to the hero image, otherwise we will not show this artist.</p>

    @formField('medias', [
        'name' => 'artist_image',
        'label' => 'Image',
    ])
@stop
