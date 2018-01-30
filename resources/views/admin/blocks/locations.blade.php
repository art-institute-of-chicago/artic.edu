    <div class="col">
        @formField('input', [
            'type' => 'text',
            'name' => 'name',
            'field_name' => 'Name',
            'label' => 'Name',
            'required' => true
        ])
        @formField('input', [
            'type' => 'text',
            'name' => 'street',
            'field_name' => 'Street',
            'label' => 'Street',
        ])
        @formField('input', [
            'type' => 'text',
            'name' => 'address',
            'field_name' => 'Address',
            'label' => 'Address',
        ])
    </div>

    <div class="col">
        @formField('input', [
            'type' => 'text',
            'name' => 'city',
            'field_name' => 'City',
            'label' => 'City',
        ])
        @formField('input', [
            'type' => 'text',
            'name' => 'state',
            'field_name' => 'State',
            'label' => 'State',
        ])
        @formField('input', [
            'type' => 'text',
            'name' => 'zip',
            'field_name' => 'ZIP code',
            'label' => 'ZIP code',
        ])
    </div>
