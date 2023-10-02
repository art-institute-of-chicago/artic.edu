@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'tour_id',
        'label' => 'Tour ID'
    ])

    @formField('input', [
        'name' => 'teaser_text',
        'label' => 'Teaser Text'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'name' => 'teaser_image',
        'label' => 'Teaser image',
    ])
@stop
