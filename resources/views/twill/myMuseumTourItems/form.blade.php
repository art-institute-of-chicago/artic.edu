@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='tour_id'
        label='Tour ID'
    />

    @formField('medias', [
        'with_multiple' => false,
        'name' => 'teaser_image',
        'label' => 'Teaser image',
    ])

    <x-twill::wysiwyg
        name='artwork_count'
        label='Artwork Count'
        :toolbar-options="[ 'italic', 'bold' ]"
    />

    <x-twill::wysiwyg
        name='teaser_text'
        label='Teaser Text'
        :toolbar-options="[ 'italic' ]"
    />


@stop
