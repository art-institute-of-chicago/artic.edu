@if($item->module_type === 'end')
    @formField('input', [
        'name' => 'headline',
        'label' => 'Headline'
    ])

    @formField('input', [
        'name' => 'end_copy',
        'label' => 'Copy',
        'placeholder' => 'The End',
    ])

    @formField('repeater', ['type' => 'end_bg_experience_image'])

    <br />

    <a17-fieldset title="Credit" id="end" :open="true">
        @formField('input', [
            'name' => 'end_credit_subhead',
            'label' => 'Subhead'
        ])

        @formField('input', [
            'name' => 'end_credit_copy',
            'label' => 'Copy'
        ])

        @formField('repeater', ['type' => 'end_experience_image'])
    </a17-fieldset>
@endif