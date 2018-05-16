@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
        'disabled' => true
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero'
    ])

    @formField('input', [
        'name' => 'caption',
        'label' => 'Caption'
    ])

    @formField('input', [
        'name' => 'also_known_as',
        'label' => 'Also known as...',
    ])

    @formField('input', [
        'name' => 'birth_date',
        'label' => 'Birth Date',
        'disabled' => true
    ])

    @formField('input', [
        'name' => 'death_date',
        'label' => 'Death Date',
        'disabled' => true
    ])

    @formField('wysiwyg', [
        'name' => 'intro',
        'label' => 'Intro',
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="attributes" title="Related">

        {{-- @formField('browser', [
            'routePrefix' => 'collection',
            'max' => 1,
            'moduleName' => 'artworks',
            'name' => 'featuredArtworks',
            'label' => 'Featured Artwork',
            'params' => [
                'artwork_ids' => $item->artwork_ids
            ]
        ]) --}}

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'name' => 'articles',
            'moduleName' => 'articles',
            'max' => 4,
            'label' => 'Related Articles',
        ])

    </a17-fieldset>
@endsection
