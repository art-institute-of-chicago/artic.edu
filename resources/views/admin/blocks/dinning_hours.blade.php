    <div class="col">
        @formField('input', [
            'name' => 'name',
            'field_name' => 'name',
            'label' => 'Name',
            'required' => true
        ])
        @formField('input', [
            'type' => 'text',
            'name' => 'hours',
            'field_name' => 'hours',
            'label' => 'Hours',
            'required' => true
        ])
        @formField('medias', [
            'name' => 'image',
            'label' => 'Image',
            'max' => '1'
        ])
    </div>
