@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'tour_id',
        'label' => 'Tour ID'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'name' => 'teaser_image',
        'label' => 'Teaser image',
    ])

    @formField('wysiwyg', [
        'name' => 'artwork_count',
        'label' => 'Artwork Count',
        'toolbarOptions' => [
            'italic', 'bold'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'teaser_text',
        'label' => 'Teaser Text',
        'toolbarOptions' => [
            'italic',
        ],
    ])


@stop
