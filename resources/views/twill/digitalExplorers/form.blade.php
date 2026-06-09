@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::formColumns>
        <x-slot name="left">
            <x-twill::medias
                name="listing"
                label="Listing Image"
                note="Minimum image width 2000px"
            />
        </x-slot>
        <x-slot name="right">
            <x-twill::select
                name="type"
                label="Display Type"
                :options="[
                    ['value' => '2d', 'label' => '2D'],
                    ['value' => '3d', 'label' => '3D']
                ]"
            />
        </x-slot>
    </x-twill::formColumns>

    @if (auth()->user()->role->id == \App\Enums\UserRole::Admin->value ||
         auth()->user()->role->id == \App\Enums\UserRole::XDPublisher->value)
        <hr>
        <h2 style="margin-top: 2rem; margin-bottom: 1rem;">Developer Settings</h2>

        <x-twill::formColumns>
            <x-slot name="left">
                <h3 style="margin-top: 1rem; margin-bottom: 1rem;">Core Settings</h3>
                <x-twill::input
                  type="text"
                  name="jsonOutput"
                  label="JSON Output"
                  note="Paste JSON output from builder"
                />

                <x-twill::checkbox
                    name="settings.antialiasing"
                    label="Antialiasing"
                />
                <x-twill::checkbox
                    name="settings.shadows"
                    label="Shadows"
                />
                <x-twill::select
                    name="settings.toneMapping"
                    label="Tone Mapping"
                    :options="[
                        ['value' => 'None', 'label' => 'None'],
                        ['value' => 'ACESFilmicToneMapping', 'label' => 'ACESFilmicToneMapping'],
                        ['value' => 'LinearToneMapping', 'label' => 'LinearToneMapping'],
                        ['value' => 'ReinhardToneMapping', 'label' => 'ReinhardToneMapping'],
                        ['value' => 'CineonToneMapping', 'label' => 'CineonToneMapping']
                    ]"
                />
                <x-twill::select
                    name="settings.colorSpace"
                    label="Color Space"
                    :options="[
                        ['value' => 'SRGB', 'label' => 'SRGB'],
                        ['value' => 'Linear', 'label' => 'Linear']
                    ]"
                />

                <h3 style="margin-top: 1rem; margin-bottom: 1rem;">Toggles</h3>
                <x-twill::checkbox
                  name="settings.builderEnabled"
                  label="Enable builder?"
                />
                <x-twill::checkbox
                  name="settings.brailleButton"
                  label="Show braille button?"
                />
                <x-twill::checkbox
                  name="settings.enableCustomBounds"
                  label="Enable custom bounds?"
                />
                <x-twill::checkbox
                  name="settings.deactivateForcefield"
                  label="Deactivate forcefield?"
                />
            </x-slot>

            <x-slot name="right">
                <h3 style="margin-top: 1rem; margin-bottom: 1rem;">Camera Constraints</h3>
                <x-twill::input
                    name="settings.cameraPosition"
                    label="Position"
                    note="Initial camera offset"
                />
                <x-twill::input
                    name="settings.cameraFov"
                    label="FOV"
                />
                <x-twill::input
                    name="settings.minDistance"
                    label="Minimum Distance"
                />
                <x-twill::input
                    name="settings.maxDistance"
                    label="Maximum Distance"
                />
                <x-twill::input
                  type="text"
                  name="settings.zoomLimits"
                  label="Zoom Limits"
                  note="Distance limits for zoom (min, max)"
                />
                <x-twill::input
                  type="text"
                  name="settings.customBounds"
                  label="Custom Bounds"
                  note="Coordinate defining the bounds of the explorer"
                />
                <x-twill::input
                  type="text"
                  name="settings.customBoundsOffset"
                  label="Custom Bounds Offset"
                  note="Coordinate offset for custom bounds"
                />
            </x-slot>
        </x-twill::formColumns>
    @endif
@stop

@php
    $model = BlockHelpers::getBlocksForEditor(['explorer_model']);
    $annotation = BlockHelpers::getBlocksForEditor(['explorer_annotation']);
    $light = BlockHelpers::getBlocksForEditor(['explorer_light']);
@endphp

@section('fieldsets')
    <x-twill::formFieldset title="Title Slide" id="title-slide">

        <x-twill::repeater
            type="explorer_title_media"
        />

        <x-twill::wysiwyg
            name='title_display'
            label='Title Text'
            note='Title of the Explorer'
        />

        <x-twill::wysiwyg
            name='title_description'
            label='Title Description'
            note='Brief description of the explorer'
        />

    </x-twill::formFieldset>

    <x-twill::formFieldset title="Info Card" id="info-card">

        <x-twill::wysiwyg
            name='info_title'
            label='Title'
            note='Title on the info card'
        />

        <x-twill::wysiwyg
            name='info_description'
            label='Description'
            note='Description of the explorer'
        />

        <x-twill::wysiwyg
            name='info_credits'
            label='Credits'
            note='Credit fields on the explorer'
        />

    </x-twill::formFieldset>

    <x-twill::formFieldset title="Models" id="models">
        <p>Models can have nested Lights and Annotations which stay attached<br/><br/>The first model in this list will be the focused model</p>
        <x-twill::block-editor
            name="model_blocks"
            :blocks="$model"
            withoutSeparator="true"
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset title="Annotations" id="annotations">
        <p>For standalone annotation points, not attached to a model</p>
        <x-twill::block-editor
            name="annotation_blocks"
            :blocks="$annotation"
            withoutSeparator="true"
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset title="Lighting" id="lights">
        <p>For standalone lighting elements, not attached to a model</p>
        <x-twill::block-editor
            name="lighting_blocks"
            :blocks="$light"
            withoutSeparator="true"
        />
    </x-twill::formFieldset>
@stop
