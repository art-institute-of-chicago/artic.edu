@extends('twill::layouts.form')

@section('contentFields')
  <x-twill::medias
    name='listing'
    label='Listing Image'
    note='Minimum image width 2000px'
  />

  <x-twill::select
    name='type'
    label='Display Type'
    :options="[
      [
        'value' => '2d',
        'label' => '2D',
      ],
      [
        'value' => '3d',
        'label' => '3D',
      ]
    ]"
  />

  <x-twill::multi-select
    name='settings.sceneSettings'
    label='Scene Settings'
    :options="[
      [
        'value' => 'antialiasing',
        'label' => 'Antialiasing'
      ],
      [
        'value' => 'shadows',
        'label' => 'Shadows'
      ],
    ]"
  />

  <x-twill::formColumns>
    <x-slot:left>
      <x-twill::select
        name='settings.toneMapping'
        label='Tone Mapping'
        :options="[
          [
            'value' => 'None',
            'label' => 'None'
          ],
          [
            'value' => 'ACESFilmicToneMapping',
            'label' => 'ACESFilmicToneMapping'
          ],
          [
            'value' => 'LinearToneMapping',
            'label' => 'LinearToneMapping'
          ],
          [
            'value' => 'ReinhardToneMapping',
            'label' => 'ReinhardToneMapping'
          ],
          [
            'value' => 'CineonToneMapping',
            'label' => 'CineonToneMapping'
          ],
        ]"
      />
    </x-slot>
    <x-slot:right>
      <x-twill::select
        name='settings.colorSpace'
        label='Color Space'
        :options="[
          [
            'value' => 'SRGB',
            'label' => 'SRGB'
          ],
          [
            'value' => 'Linear',
            'label' => 'Linear'
          ],
        ]"
      />
    </x-slot>
  </x-twill::formColumns>
@stop

@php
    $model = BlockHelpers::getBlocksForEditor([
      'explorer_model'
    ]);

    $annotation = BlockHelpers::getBlocksForEditor([
      'explorer_annotation'
    ]);

    $light = BlockHelpers::getBlocksForEditor([
      'explorer_light'
    ]);
@endphp
<br/>
@section('fieldsets')
  <x-twill::formFieldset title="Models" id="models">

    <p>Models can have nested Lights and Annotations which stay attached<br/><br/>The first model in this list will be considered the focus model</p>

    <x-twill::block-editor
      name='model_blocks'
      :blocks='$model'
      withoutSeparator='true'
    />
  </x-twill::formFieldset>

  <x-twill::formFieldset title="Annotations" id="annotations">

    <p>For standalone annotation points, not attached to a model</p>

    <x-twill::block-editor
      name='annotation_blocks'
      :blocks='$annotation'
      withoutSeparator='true'
    />
  </x-twill::formFieldset>

  <x-twill::formFieldset title="Lighting" id="lights">

    <p>For standalone lighting elements, not attached to a model</p>

    <x-twill::block-editor
      name='lighting_blocks'
      :blocks='$light'
      withoutSeparator='true'
    />
  </x-twill::formFieldset>

    <x-twill::formFieldset title="Camera" id="camera">

    <p>By default the camera will orbit the first model. If you wish to override you must set camera values manually.</p>

  </x-twill::formFieldset>
@stop