@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='title'
        label='Title'
        :required='true'
    />

    <x-twill::input
        name='tooltip'
        label='Tooltip'
    />

    <x-twill::wysiwyg
        name='description'
        label='Description'
        note='Will display instead of price table'
        :toolbar-options="[ 'italic', 'link' ]"
    />

    <x-twill::input
        name='link_label'
        label='Link label'
    />

    <x-twill::input
        name='link_url'
        label='Link URL'
    />
@stop
