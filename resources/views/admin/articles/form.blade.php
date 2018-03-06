@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Publishing date',
    ])

    @formField('select', [
        'name' => 'layout_type',
        'label' => 'Article layout',
        'options' => $articleLayoutsList,
        'default' => '0'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero'
    ])

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])

    @formField('input', [
        'name' => 'type',
        'label' => 'Article Type'
    ])

    @formField('input', [
        'name' => 'heading',
        'label' => 'Headline',
        'rows' => 3,
        'type' => 'textarea'
    ])

    @formField('input', [
        'name' => 'author',
        'label' => 'Author'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Author Thumbnail',
        'name' => 'hero'
    ])

    @formField('checkbox', [
        'name' => 'is_boosted',
        'label' => 'Boost this Article on search results'
    ])

    @formField('block_editor', [
        'blocks' => [
            'text', 'image_with_caption', 'video_with_caption', 'gallery', 'media_embed', 'quote', 'list', 'artwork', 'artworks'
        ]
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="attributes" title="Related">

        @formField('browser', [
            'routePrefix' => 'whatson',
            'name' => 'articles',
            'moduleName' => 'articles',
            'max' => 20,
            'label' => 'Related Articles',
        ])

        @formField('browser', [
            'routePrefix' => 'whatson',
            'name' => 'selections',
            'moduleName' => 'selections',
            'max' => 20,
            'label' => 'Related Selections',
        ])

        @formField('browser', [
            'routePrefix' => 'whatson',
            'name' => 'artworks',
            'moduleName' => 'artworks',
            'label' => 'Artworks',
            'max' => 500
        ])

        @formField('browser', [
            'routePrefix' => 'whatson',
            'name' => 'exhibitions',
            'moduleName' => 'exhibitions',
            'max' => 20,
            'label' => 'Related Exhibitions',
        ])

    </a17-fieldset>
@endsection
