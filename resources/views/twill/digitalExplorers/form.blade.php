@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::medias
        name="listing"
        label="Listing Image"
        note="Minimum image width 2000px"
    />

    <x-twill::select
        name="type"
        label="Display Type"
        :options="[
            ['value' => '2d', 'label' => '2D'],
            ['value' => '3d', 'label' => '3D']
        ]"
    />

    <x-twill::multi-select
        name="settings.sceneSettings"
        label="Scene Settings"
        :options="[
            ['value' => 'antialiasing', 'label' => 'Antialiasing'],
            ['value' => 'shadows', 'label' => 'Shadows']
        ]"
    />

    <x-twill::formColumns>
        <x-slot name="left">
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

            <x-twill::checkbox
              name="settings.debug"
              label="Show debugger?"
            />
        </x-slot>

        <x-slot name="right">
            <x-twill::select
                name="settings.colorSpace"
                label="Color Space"
                :options="[
                    ['value' => 'SRGB', 'label' => 'SRGB'],
                    ['value' => 'Linear', 'label' => 'Linear']
                ]"
            />
        </x-slot>
    </x-twill::formColumns>
@stop

@php
    $model = BlockHelpers::getBlocksForEditor(['explorer_model']);
    $annotation = BlockHelpers::getBlocksForEditor(['explorer_annotation']);
    $light = BlockHelpers::getBlocksForEditor(['explorer_light']);
@endphp

@section('fieldsets')
    <x-twill::formFieldset title="Title Slide" id="title-slide">

        <x-twill::medias
            name="title_media"
            label="Title Media"
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

    <x-twill::formFieldset title="Camera Offset" id="camera">
        <p>By default the camera will orbit the first model. These settings will be used for the initial offset</p>
        <x-twill::input
            name="settings.position"
            label="Position"
        />
        <x-twill::input
            name="settings.rotation"
            label="Rotation"
        />
        <x-twill::input
            name="settings.scale"
            label="Scale"
        />
    </x-twill::formFieldset>
@stop
