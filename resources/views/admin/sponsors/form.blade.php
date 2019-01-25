@extends('twill::layouts.form')

@section('contentFields')
    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image',
            'split_block'
        ])
    ])
@stop
