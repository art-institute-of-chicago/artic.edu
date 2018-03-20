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
        @formField('input', [
            'type' => 'text',
            'name' => 'text',
            'field_name' => 'text',
            'label' => 'Text',
            'required' => true
        ])
    </div>
