@twillBlockTitle('Featured Pages Grid')
@twillBlockIcon('image')

<x-twill::input
    name='heading'
    label='Heading'
/>

<x-twill::browser
    name='genericPages'
    label='Featured Pages'
    route-prefix='generic'
    module-name='genericPages'
    :max='8'
    :modules="[
        [
            'label' => 'Generic Pages',
            'name' => 'generic.genericPages'
        ],
        [
            'label' => 'Landing Pages',
            'name' => 'generic.landingPages'
        ]
    ]"
/>
