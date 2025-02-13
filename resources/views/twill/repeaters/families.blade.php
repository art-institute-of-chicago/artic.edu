@twillRepeaterTitle('Explore on your own')
@twillRepeaterTrigger('Add item')
@twillRepeaterComponent('a17-block-families')
@twillRepeaterMax('3')

    <div class="col">
        <x-twill::medias
            name='family_cover'
            label='Image'
            :max='1'
        />
        <x-twill::input
            name='title'
            label='Title'
            :required='true'
        />
        <x-twill::input
            name='associated_generic_page_link'
            label='Associated generic page link'
            :required='false'
        />
        <x-twill::wysiwyg
            name='text'
            label='Text'
            :required='true'
        />
        <x-twill::input
            name='link_label'
            label='Link Label'
            :required='true'
        />
        <x-twill::input
            name='external_link'
            label='Link URL'
            :required='true'
        />
    </div>
