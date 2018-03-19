@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Hero image',
        'name' => 'hero'
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short Description',
        'type' => 'textarea'
    ])
    @formField('block_editor', [
        'blocks' => ['image', 'title', 'quote', 'charvet']
    ])
@stop
