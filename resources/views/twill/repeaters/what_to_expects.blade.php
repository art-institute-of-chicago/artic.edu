@twillRepeaterTitle('What to Expect')
@twillRepeaterTrigger('Add item')
@twillRepeaterComponent('a17-block-what_to_expect')
@twillRepeaterMax('9')

    <div class="col">
        <x-twill::select
            name='icon_type'
            label='Icon'
            default='0'
            :options="\App\Models\Page::getIconTypes()"
        />
        <x-twill::input
            name='text'
            label='Text'
            :required='true'
        />
    </div>
