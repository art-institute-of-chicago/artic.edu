@twillRepeaterTitle('What to Expect')
@twillRepeaterTrigger('Add item')
@twillRepeaterComponent('a17-block-what_to_expect')
@twillRepeaterMax('9')

    <div class="col">
        @formField('select', [
            'name' => 'icon_type',
            'label' => 'Icon',
            'options' => \App\Models\Page::getIconTypes(),
            'default' => 0
        ])
        @formField('input', [
            'name' => 'text',
            'field_name' => 'text',
            'label' => 'Text',
            'required' => true
        ])
    </div>
