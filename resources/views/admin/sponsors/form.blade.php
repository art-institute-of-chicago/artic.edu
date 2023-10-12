@extends('twill::layouts.form')

@section('contentFields')
    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'image', 'paragraph',
            'split_block'
        ])
    ])
@stop
