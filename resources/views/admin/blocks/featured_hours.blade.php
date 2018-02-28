    <div class="col">
        @formField('medias', [
            'name' => 'image',
            'label' => 'Image',
            'max' => '1'
        ])
        @formField('input', [
            'name' => 'intro',
            'field_name' => 'intro',
            'label' => 'Intro',
            'required' => true
        ])
        @formField('input', [
            'type' => 'text',
            'name' => 'hours',
            'field_name' => 'hours',
            'label' => 'Hours',
            'required' => true
        ])
    </div>
