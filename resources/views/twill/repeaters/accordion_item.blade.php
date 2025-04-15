@twillRepeaterTitle('Accordion Item')
@twillRepeaterTrigger('Add accordion item')
@twillRepeaterComponent('a17-block-accordion_item')
@twillRepeaterMax('20')

<x-twill::input
    name='header'
    label='Header'
    :maxlength='60'
/>

<x-twill::wysiwyg
    type='textarea'
    name='description'
    label='Description'
    :rows='4'
    :toolbar-options="[ ['header' => 4], 'bold', 'italic', 'underline', 'link', 'list-unordered' ]"
/>
