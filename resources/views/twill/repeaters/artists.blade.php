@twillRepeaterTitle('Artists')
@twillRepeaterTrigger('Add Artist')
@twillRepeaterComponent('a17-block-artists')
@twillRepeaterMax(10)

<x-twill::browser
    name='artists'
    label='Artists'
    route-prefix='collection'
    module-name='artists'
    :max='1'
/>

<p class="f-note">If no image is selected, we will fall back to the hero image, otherwise we will not show this artist.</p>

<x-twill::medias
    name='artist_image'
    label='Image'
/>
