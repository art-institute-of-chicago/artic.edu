@twillBlockTitle('Banner')
@twillBlockIcon('text')

<x-twill::medias
    name='membership_banner_image'
    label='Image'
    :max='1'
/>

<x-twill::input
    name='headline'
    label='Headline'
    :maxlength='50'
    :translated='true'
/>

<x-twill::input
    name='short_copy'
    label='Short copy'
    :maxlength='80'
    :translated='true'
/>

<x-twill::input
    name='url_address'
    label='Link'
/>

<x-twill::input
    name='link_text'
    label='Button text'
    :translated='true'
/>
