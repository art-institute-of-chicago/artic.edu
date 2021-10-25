@twillRepeaterTitle('FAQ')
@twillRepeaterTrigger('Add FAQ')
@twillRepeaterComponent('a17-block-faqs')
@twillRepeaterMax('5')

    <div class="col">
        @formField('input', [
            'name' => 'title',
            'field_name' => 'title',
            'label' => 'Title',
            'required' => true
        ])
        @formField('input', [
            'name' => 'link',
            'field_name' => 'link',
            'label' => 'Link',
            'required' => true
        ])
    </div>
