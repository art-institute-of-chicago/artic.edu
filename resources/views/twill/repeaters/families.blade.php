@twillRepeaterTitle('Explore on your own')
@twillRepeaterTrigger('Add item')
@twillRepeaterComponent('a17-block-families')
@twillRepeaterMax('3')

    <div class="col">
        @formField('medias', [
            'name' => 'family_cover',
            'label' => 'Image',
            'max' => '1'
        ])
        @formField('input', [
            'name' => 'title',
            'field_name' => 'title',
            'label' => 'Title',
            'required' => true
        ])
        @formField('input', [
            'name' => 'associated_generic_page_link',
            'field_name' => 'associated_generic_page_link',
            'label' => 'Associated generic page link',
            'required' => false
        ])
        @formField('wysiwyg', [
            'name' => 'text',
            'field_name' => 'text',
            'label' => 'Text',
            'required' => true
        ])
        @formField('input', [
            'name' => 'link_label',
            'field_name' => 'link_label',
            'label' => 'Link Label',
            'required' => true
        ])
        @formField('input', [
            'name' => 'external_link',
            'field_name' => 'external_link',
            'label' => 'Link URL',
            'required' => true
        ])
    </div>
