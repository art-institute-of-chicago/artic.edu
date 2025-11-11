@twillRepeaterTitle('Model')
@twillRepeaterTrigger('Add Model')
@twillRepeaterComponent('a17-block-digital_explorer_model')


    <x-twill::files
      name='modelFile'
      label='Model'
      note='Add a 3D model'
    />

    <x-twill::checkbox
      name='settings.isTarget'
      label='Main target'
    />

    <x-twill::input
      name='settings.position'
      label='Position'
    />

    <x-twill::input
      name='settings.rotation'
      label='Rotation'
    />

    <x-twill::input
      name='settings.scale'
      label='Scale'
    />

    <x-twill::input
      name='settings.modelId'
      label='Custom Model ID'
      note='Used for targeting'
    />

<x-twill::multi-select
    name='modelSettings'
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
