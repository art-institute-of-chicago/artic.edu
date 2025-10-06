@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='name'
        label='Name'
        translated='true'
    />

    <x-twill::input
        name='file'
        label='File'
        disabled='true'
    />
@stop

@section('sideFieldsets')
    <a17-fieldset title="YouTube" id="youtube">
        <x-twill::input
            name='youtube_id'
            label='YouTube ID'
            translated='true'
            disabled='true'
        />

        <x-twill::input
            name='kind'
            label='Kind'
            disabled='true'
        />

        <x-twill::browser
            name='video'
            label='Video'
            route-prefix='collection.articlesPublications'
            module-name='videos'
            disabled='true'
            note='Read-only'
            itemLabel=''
        />
    </a17-fieldset>
@endsection
