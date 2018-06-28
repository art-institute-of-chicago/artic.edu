@extends('twill::layouts.form')

@section('contentFields')
    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image'
        ]
    ])
@stop
