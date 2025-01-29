@twillRepeaterTitle('Dining')
@twillRepeaterTrigger('Add dining hours')
@twillRepeaterComponent('a17-block-dining_hours')
@twillRepeaterMax('3')

    <div class="col">
        <x-twill::input
            name='name'
            label='Name'
            :required='true'
        />
        <x-twill::input
            name='hours'
            label='Hours'
            :required='true'
        />
        <x-twill::medias
            name='dining_cover'
            label='Image'
            :max='1'
        />
    </div>
