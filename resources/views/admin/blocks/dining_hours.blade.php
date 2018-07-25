    <div class="col">
        @formField('input', [
            'name' => 'name',
            'field_name' => 'name',
            'label' => 'Name',
            'required' => true,
            'translated' => true
        ])
        @formField('input', [
            'type' => 'text',
            'name' => 'hours',
            'field_name' => 'hours',
            'label' => 'Hours',
            'required' => true,
            'translated' => true
        ])
        @formField('medias', [
            'name' => 'dining_cover',
            'label' => 'Image',
            'max' => '1'
        ])
    </div>
