@extends('twill::layouts.form')

@section('contentFields')
    <br/>
    <h1><strong>iPad URL:</strong> {{ 'https' . $baseUrl . $item->slug . '/ipad'}}</h1>
    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])
    @formField('input', [
        'label' => 'Subtitle',
        'name' => 'sub_title',
    ])
@stop