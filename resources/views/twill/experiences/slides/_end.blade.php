@if($item->module_type === 'end')
    <x-twill::input
        name='headline'
        label='Headline'
        :maxlength='150'
    />

    <x-twill::input
        name='end_copy'
        label='Copy'
        placeholder='The End'
        :maxlength='150'
    />

    @formField('repeater', ['type' => 'end_bg_experience_image'])

    <br />

    <a17-fieldset title="Credits and Acknowledgements" id="end" :open="true">
        <x-twill::input
            name='end_credit_subhead'
            label='Subhead'
            :maxlength='150'
        />

        <x-twill::wysiwyg
            name='end_credit_copy'
            label='Copy'
            :toolbar-options="[ ['header' => 2], 'bold', 'italic' ]"
        />

        @formField('repeater', ['type' => 'end_experience_image'])
    </a17-fieldset>
@endif
