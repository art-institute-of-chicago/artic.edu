@twillBlockTitle('Split block')
@twillBlockIcon('text')

@formField('radios', [
    'name' => 'variation',
    'label' => 'Variation',
    'default' => 'quarter',
    'inline' => true,
    'options' => [
        [
            'value' => 'quarter',
            'label' => 'Quarter block'
        ],
        [
            'value' => 'half',
            'label' => 'Half block'
        ],
    ]
])

@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => 1
])

@formField('input', [
    'name' => 'image_link',
    'label' => 'Link (optional)',
    'note' => 'Makes image clickable',
])

{!! app(\A17\Twill\Services\Blocks\BlockCollection::class)->findByName('paragraph')->render() !!}
