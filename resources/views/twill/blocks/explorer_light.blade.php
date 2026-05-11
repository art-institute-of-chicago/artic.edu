@twillBlockTitle('Explorer Light')
@twillBlockIcon('closer_look')

<x-twill::select
  name='lightType'
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
      field-name='lightType'
      field-values='pointLight'
      :render-for-blocks='true'
      :keep-alive='true'
  >

    <x-twill::checkbox
      name='cameraAttached'
      label='Attach light to camera'
    />

  </x-twill::formConnectedFields>

@if (auth()->user()->role->id == \App\Enums\UserRole::Admin->value ||
     auth()->user()->role->id == \App\Enums\UserRole::XDPublisher->value)
    <hr>
    <h2 style="margin-top: 2rem; margin-bottom: 1rem;">Developer Settings</h2>
    
    <x-twill::formColumns>
        <x-slot name="left">
            <x-twill::input
                name='target'
                label='Light target ID'
                note='Reference the ID of a model or element to target if not nested'
            />
            
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
            <x-twill::input
                name='intensity'
                label='Light Intensity'
            />
        
            <x-twill::input
                name='color'
                label='Light Color'
                placeholder='#FFFFFF'
            />
        </x-slot>
    </x-twill::formColumns>
@endif