@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Management',
    'additionalFieldsets' => [
        ['fieldset' => 'content', 'label' => 'Management'],
        ['fieldset' => 'ad', 'label' => 'Advertisement'],
        ['fieldset' => 'targets', 'label' => 'Targets'],
    ]
])

@section('contentFields')
    <x-twill::input
        type="text"
        name="title"
        label="Title"
        note="Internal use only"
    />
    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::date-picker
                name="start_date"
                label="Start Date"
                :with-time='false'
            />
        </x-slot>
        <x-slot:right>
            <x-twill::date-picker
                name="end_date"
                label="End Date"
                :with-time='false'
            />
        </x-slot>
    </x-twill::formColumns>
@endsection

@section('fieldsets')
    <x-twill::formFieldset id="ad" title="Advertisement">
        <x-twill::medias
            name="hero"
            label="Hero image"
        />
        <x-twill::input
            type="text"
            name="header"
            label="Header"
        />
        <x-twill::wysiwyg
            name="description"
            label="Description"
            :toolbar-options="['italic']"
        />
        <x-twill::formColumns>
            <x-slot:left>
                <x-twill::input
                    type="text"
                    name="destination_label"
                    label="Destination Label"
                />
            </x-slot>
            <x-slot:right>
                <x-twill::input
                    type="url"
                    name="destination_url"
                    label="Destination URL"
                />
            </x-slot>
        </x-twill::formColumns>
    </x-twill::formFieldset>
    <x-twill::formFieldset id="targets" title="Artist & Artwork Targets">
        <x-twill::browser
            name="artists"
            label="Artist"
            route-prefix="collection"
            module-name="artists"
            :max='10'
        />
        <x-twill::browser
            name="artworks"
            label="Artworks"
            route-prefix="collection"
            module-name="artworks"
            :sortable='false'
            :max='10'
        />
    </x-twill::formFieldset>
@endsection
