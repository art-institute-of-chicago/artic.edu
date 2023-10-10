@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'tour_id',
        'label' => 'Tour ID'
    ])

    @formField('wysiwyg', [
        'name' => 'teaser_text',
        'label' => 'Teaser Text',
        'toolbarOptions' => [
            'italic',
        ],
    ])

    @formField('medias', [
        'with_multiple' => false,
        'name' => 'teaser_image',
        'label' => 'Teaser image',
    ])
@stop
