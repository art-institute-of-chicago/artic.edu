@twillRepeaterTitle('Link Tag')
@twillRepeaterTitleField('label', ['hidePrefix' => true])
@twillRepeaterTrigger('Add tag')
@twillBlockValidationRules([
    'label' => 'required|string',
    'url' => 'required|string',
])

<x-twill::formColumns>
    <x-slot:left>
        <x-twill::input
            name='label'
            label='Label'
            :required='true'
        />
    </x-slot:left>
    <x-slot:right>
        <x-twill::input
            name='url'
            label='URL'
            :required='true'
        />
    </x-slot:right>
</x-twill::formColumns>
