@extends('twill::layouts.form')

@section('contentFields')

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List description',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used for social media.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @include('admin.partials.hero')

    <hr>

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            // TODO: Custom magazine-only blocks here?
        ])
    ])

@stop
