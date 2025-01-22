<x-twill::input
    name='author_display'
    label='Author display'
    :maxlength='255'
/>

<x-twill::browser
    name='authors'
    label='Authors'
    route-prefix='collection'
    module-name='authors'
    :max='10'
/>
