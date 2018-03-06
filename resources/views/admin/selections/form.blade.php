@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])

    @formField('multi_select', [
        'name' => 'siteTags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])

    @formField('input', [
        'name' => 'short_copy',
        'label' => 'Short Intro copy',
        'type' => 'textarea'
    ])

    @formField('medias', [
        'name' => 'hero',
        'label' => 'Hero Image'
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
        'moduleName' => 'articles',
        'name' => 'articles',
        'label' => 'Article'
    ])

    @formField('block_editor', [
        'blocks' => [
            'image', 'image_with_caption', 'gallery', 'media_embed', 'paragraph', 'artwork', 'artworks'
        ]
    ])
@stop
