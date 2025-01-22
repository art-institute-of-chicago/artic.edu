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
            'value' => moduleRoute('genericPages', 'generic', 'browser', [], false)
        ],
        [
            'label' => 'Landing Pages',
            'value' => moduleRoute('landingPages', 'generic', 'browser', [], false)
        ]
    ]"
/>
