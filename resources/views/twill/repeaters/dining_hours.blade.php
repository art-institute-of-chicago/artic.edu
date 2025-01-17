@twillRepeaterTitle('Dining')
@twillRepeaterTrigger('Add dining hours')
@twillRepeaterComponent('a17-block-dining_hours')
@twillRepeaterMax('3')

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
            'name' => 'dining_cover',
            'label' => 'Image',
            'max' => '1'
        ])
    </div>
