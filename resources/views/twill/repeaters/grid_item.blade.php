@twillRepeaterTitle('Grid Item')
@twillRepeaterTrigger('Add Grid Item')
@twillRepeaterComponent('a17-block-grid_item')
@twillRepeaterMax('48')

@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => '1'
])

<x-twill::wysiwyg
    name='title'
    label='Title'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::input
    name='tag'
    label='Tag'
    note='Displayed in smaller font above title'
/>

<x-twill::wysiwyg
    type='textarea'
    name='description'
    label='Description'
    :rows='4'
    :toolbar-options="[ 'italic' ]"
/>

@component('twill::partials.form.utils._columns')
@slot('left')

<x-twill::input
    name='label'
    label='Label'
/>
@endslot

@slot('right')
<x-twill::radios
    name='label_position'
    label='Label position'
    note=''
    :inline='true'
    :options="[
        [
            'value' => 'overlay',
            'label' => 'Bottom of image'
        ],
        [
            'value' => 'description',
            'label' => 'Below description'
        ]
    ]"
/>
@endslot
@endcomponent

<x-twill::input
    name='url'
    label='URL'
/>
