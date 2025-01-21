@extends('twill::layouts.form')

@section('contentFields')

    <x-twill::medias
        name='hero'
        label='Hero Image'
        note='Minimum image width 2000px'
    />

    <x-twill::input
        name='caption'
        label='Caption'
        :maxlength='255'
    />

    <x-twill::wysiwyg
        name='intro'
        label='Intro'
    />

    <x-twill::input
        name='datahub_id'
        label='Datahub ID'
        disabled='true'
    />
@stop

@section('fieldsets')
    @include('twill.partials.meta')
@endsection
