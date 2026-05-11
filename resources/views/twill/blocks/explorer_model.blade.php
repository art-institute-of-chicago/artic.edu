@twillBlockTitle('Explorer Model')
@twillBlockIcon('image')

    <x-twill::input
        name='label'
        label='Label'
        note='Label for the model'
    />

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

@if (auth()->user()->role->id == \App\Enums\UserRole::Admin->value ||
     auth()->user()->role->id == \App\Enums\UserRole::XDPublisher->value)
    <hr>
    <h2 style="margin-top: 2rem; margin-bottom: 1rem;">Developer Settings</h2>
    
    <x-twill::formColumns>
        <x-slot name="left">
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
        </x-slot>
        
        <x-slot name="right">
            <x-twill::multi-select
                name='settings'
                label='Settings'
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
        </x-slot>
    </x-twill::formColumns>
@endif

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
