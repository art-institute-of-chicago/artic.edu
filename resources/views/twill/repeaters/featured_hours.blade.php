@twillRepeaterTitle('Museum Hours')
@twillRepeaterTrigger('Add hours')
@twillRepeaterComponent('a17-block-featured_hours')
@twillRepeaterMax('3')

    <div class="col">
        <x-twill::input
            name='title'
            label='Title'
            :required='true'
        />
        <x-twill::input
            name='external_link'
            label='Link'
            :required='true'
        />
        <x-twill::wysiwyg
            name='copy'
            label='Text'
            :required='true'
            :rows='3'
        />
    </div>
