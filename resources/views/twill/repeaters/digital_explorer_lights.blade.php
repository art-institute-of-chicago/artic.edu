@twillRepeaterTitle('Light')
@twillRepeaterTrigger('Add Light')
@twillRepeaterComponent('a17-block-digital_explorer_light')

<x-twill::select
  name='settings.lightType'
  label='Light Type'
  :options="[
    [
      'value' => 'ambient',
      'label' => 'Ambient'
    ],
    [
      'value' => 'pointLight',
      'label' => 'Point Light'
    ],
    [
      'value' => 'directionalLight',
      'label' => 'Directional Light'
    ]
  ]"
/>

  <x-twill::formConnectedFields
      field-name='settings.lightType'
      field-values='pointLight'
      :render-for-blocks='true'
      :keep-alive='true'
  >

    <x-twill::checkbox
      name='settings.cameraAttached'
      label='Attach light to camera'
    />

  </x-twill::formConnectedFields>

<x-twill::input
  name='settings.target'
  label='Light target ID'
  note='Reference the ID of a model or element to target'
/>

<x-twill::formColumns>
  <x-slot:left>
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
  </x-slot>

  <x-slot:right>

    <x-twill::input
      name='settings.intensity'
      label='Light Intensity'
    />

    <x-twill::input
      name='settings.color'
      label='Light Color'
    />

  </x-slot>
</x-twill::formColumns>