@extends('twill::layouts.form', [

    'additionalFieldsets' => [

        ['fieldset' => 'models', 'label' => '3D Models'],
        ['fieldset' => 'lights', 'label' => 'Lights'],
        ['fieldset' => 'annotations', 'label' => 'Annotations'],

    ]

])

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

@section('fieldsets')
  <x-twill::formFieldset title="3D Models" id="models">
    <x-twill::repeater type='digital_explorer_models' />
  </x-twill::formFieldset>

  <x-twill::formFieldset title="Annotations" id="annotations">
    <x-twill::repeater type='digital_explorer_annotations' />
  </x-twill::formFieldset>

  <x-twill::formFieldset title="Lighting" id="lights">
    <x-twill::repeater type='digital_explorer_lights' />
  </x-twill::formFieldset>
@stop