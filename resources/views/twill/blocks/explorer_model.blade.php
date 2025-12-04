@twillBlockTitle('Explorer Model')
@twillBlockIcon('image')

    <x-twill::select
      name='modelType'
      label='Model Type'
      placeholder='Select a model type'
      :required='true'
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

  <x-twill::formConnectedFields
      field-name='modelType'
      field-values='3d'
      :render-for-blocks='true'
      :keep-alive='true'
  >

    <x-twill::files
      name='model'
      label='3D Model'
      note='Add a model'
    />

  </x-twill::formConnectedFields>

  <x-twill::formConnectedFields
      field-name='modelType'
      field-values='2d'
      :render-for-blocks='true'
      :keep-alive='true'
  >

    <x-twill::medias
      name='image'
      label='Image'
      note='Add an image'
    />

  </x-twill::formConnectedFields>

    <x-twill::input
        name="coordinate"
        label="Position"
        placeholder="[0, 0, 0]"
    />

    <x-twill::input
        name="rotation"
        label="Rotation"
        placeholder="[0, 0, 0]"
    />

    <x-twill::input
      name='scale'
      label='Scale'
      placeholder="1.0"
    />

<x-twill::multi-select
    name='settings'
    label=''
    :unpack='true'
    :options="[
      [
        'value' => 'castShadow',
        'label' => 'Cast shadow'
      ],
      [
        'value' => 'receiveShadow',
        'label' => 'Receive shadow'
      ],
      [
        'value' => 'enableControls',
        'label' => 'Enable Controls'
      ],
    ]"
/>

@php
    $modelInstanceBlocks = BlockHelpers::getBlocksForEditor([
      'explorer_model',
      'explorer_annotation',
      'explorer_light'
    ]);
@endphp

<x-twill::block-editor
  name='model_instance_blocks'
  :blocks='$modelInstanceBlocks'
  withoutSeparator='true'
/>