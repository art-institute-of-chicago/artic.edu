@extends('twill::layouts.form')

@section('contentFields')
    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image',
            'split_block'
        ])
    ])
@stop
