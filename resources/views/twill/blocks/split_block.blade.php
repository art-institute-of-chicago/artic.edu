@twillBlockTitle('Split block')
@twillBlockIcon('text')

<x-twill::radios
    name='variation'
    label='Variation'
    default='quarter'
    :inline='true'
    :options="[
        [
            'value' => 'quarter',
            'label' => 'Quarter block'
        ],
        [
            'value' => 'half',
            'label' => 'Half block'
        ]
    ]"
/>

<x-twill::medias
    name='image'
    label='Image'
    :max='1'
/>

<x-twill::input
    name='image_link'
    label='Link (optional)'
    note='Makes image clickable'
/>

{!! TwillBlocks::getBlockCollection()->findByName('paragraph')->renderForm() !!}
