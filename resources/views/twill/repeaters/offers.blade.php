@twillRepeaterTitle('Offers')
@twillRepeaterTrigger('Add offer')
@twillRepeaterComponent('a17-block-offers')
@twillRepeaterMax('10')

@formField('medias', [
    'name' => 'hero',
    'label' => 'Image',
    'max' => '1'
])

<x-twill::input
    name='title'
    label='Title'
/>

<x-twill::input
    type='textarea'
    name='description'
    label='Description'
    :rows='4'
/>

<x-twill::input
    name='label'
    label='Label'
    note='Displayed at bottom-right of image'
/>

<x-twill::input
    name='url'
    label='URL'
/>
