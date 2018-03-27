    <div class="col">
        @formField('input', [
            'name' => 'title',
            'field_name' => 'title',
            'label' => 'Title',
            'required' => true
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
            'label' => 'Link',
            'required' => true
        ])
        @formField('medias', [
            'name' => 'family_cover',
            'label' => 'Image',
            'max' => '1'
        ])
    </div>
