@extends('twill::layouts.form')

@section('contentFields')
    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'split_block'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />
@stop
