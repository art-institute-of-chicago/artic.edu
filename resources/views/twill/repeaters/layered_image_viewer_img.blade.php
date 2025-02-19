@twillRepeaterTitle('Image')
@twillRepeaterTrigger('Add image')
@twillRepeaterComponent('a17-block-layered_image_viewer_img')
@twillRepeaterMax('10')


<x-twill::medias
    name='image'
    label='Image'
    :max='1'
/>

<x-twill::input
    name='label'
    label='Label'
    note='Displayed at bottom of image'
    :maxlength='82'
/>
