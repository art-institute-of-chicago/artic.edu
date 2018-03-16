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
        'label' => 'Categories Topics',
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
        'name' => 'author'
    ])

    @formField('checkbox', [
        'name' => 'is_boosted',
        'label' => 'Boost this Article on search results'
    ])

    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image', 'video', 'gallery', 'media_embed', 'quote',
            'list', 'artwork', 'artworks', 'references', 'citation'
        ]
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="attributes" title="Related">

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'name' => 'articles',
            'moduleName' => 'articles',
            'max' => 1,
            'label' => 'Related Articles',
        ])

        @formField('browser', [
            'routePrefix' => 'collection',
            'name' => 'selections',
            'moduleName' => 'selections',
            'max' => 1,
            'label' => 'Related Selections',
        ])

        @formField('browser', [
            'routePrefix' => 'collection',
            'name' => 'artworks',
            'moduleName' => 'artworks',
            'label' => 'Artworks',
            'max' => 500
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'name' => 'exhibitions',
            'moduleName' => 'exhibitions',
            'max' => 1,
            'label' => 'Related Exhibitions',
        ])

    </a17-fieldset>
@endsection
