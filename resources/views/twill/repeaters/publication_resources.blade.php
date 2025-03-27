@twillRepeaterTitle('Publications Resource')
@twillRepeaterTrigger('Add publications resource')
@twillRepeaterComponent('a17-block-publication_resource')


<x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='resource_title'
                label='Title of resource'
            />
        </x-slot>

        <x-slot:right>
            <x-twill::input
                name='resource_target'
                label='Title for anchor link'
                note='Adds a link in subnav to this resource'
            />
        </x-slot>
</x-twill::formColumns>

<x-twill::input
    name='resource_description'
    label='Description'
    type='textarea'
/>

<x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='resource_link_label'
                label='Link label'
            />
        </x-slot>

        <x-slot:right>
            <x-twill::input
                name='resource_link_url'
                label='Link URL'
            />
        </x-slot>
</x-twill::formColumns>