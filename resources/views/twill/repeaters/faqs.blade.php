@twillRepeaterTitle('FAQ')
@twillRepeaterTrigger('Add FAQ')
@twillRepeaterComponent('a17-block-faqs')
@twillRepeaterMax('10')

    <div class="col">
        @formField('input', [
            'name' => 'title',
            'field_name' => 'title',
            'label' => 'Title',
        ])
        @formField('input', [
            'name' => 'link',
            'field_name' => 'link',
            'label' => 'Link',
        ])
        @formField('wysiwyg', [
            'name' => 'question',
            'field_name' => 'question',
            'label' => 'Question',
            'note' => 'For use only in Landing Pages',
        ])
        @formField('wysiwyg', [
            'name' => 'answer',
            'field_name' => 'answer',
            'label' => 'Answer',
            'note' => 'For use only in Landing Pages',
        ])
    </div>
