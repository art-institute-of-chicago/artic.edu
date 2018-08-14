@extends('twill::layouts.form')

@section('contentFields')
    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image',
            'split_block'
        ]
    ])
@stop
