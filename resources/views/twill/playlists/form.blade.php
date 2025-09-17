@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='title'
        label='Title'
        disabled='true'
    />

    <x-twill::formColumns>
        <x-slot:left>
            <img
                style="margin-top: 35px; width: 100%"
                src='{{ $item->thumbnail_url }}'
            />
        </x-slot:left>
        <x-slot:right>
        </x-slot:right>
    </x-twill::formColumns>
@stop

@section('sideFieldsets')
    <a17-fieldset title="YouTube" id="youtube">
        <x-twill::input
            name='youtube_id'
            label='YouTube ID'
            disabled='true'
        />
        <a href="{{ $item->source_url }}" target="_blank">🔗 YouTube</a>

        <x-twill::browser
            name='videos'
            label='Videos'
            note='Read-only'
            module-name='videos'
            route-prefix='collection.articlesPublications'
            disabled='true'
            itemLabel=''
        />
    </a17-fieldset>
@endsection
