    <div class="col">
        @formField('input', [
            'name' => 'title',
            'field_name' => 'title',
            'label' => 'Title',
            'required' => true
        ])
        @formField('input', [
            'name' => 'external_link',
            'field_name' => 'external_link',
            'label' => 'link',
            'required' => true
        ])
        @formField('wysiwyg', [
            'rows' => 3,
            'name' => 'copy',
            'field_name' => 'copy',
            'label' => 'Text',
            'required' => true
        ])
    </div>
