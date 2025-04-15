@twillBlockTitle('Feature 2x')
@twillBlockIcon('image')

<x-twill::browser
    name='experiences'
    label='Featured items'
    route-prefix='collection.interactiveFeatures'
    module-name='experiences'
    :max='2'
/>
