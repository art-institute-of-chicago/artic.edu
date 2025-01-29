@twillRepeaterTitle('FAQ')
@twillRepeaterTrigger('Add FAQ')
@twillRepeaterComponent('a17-block-faqs')
@twillRepeaterMax('10')

    <div class="col">
        <x-twill::input
            name='title'
            label='Title'
        />
        <x-twill::input
            name='link'
            label='Link'
        />
        <x-twill::wysiwyg
            name='question'
            label='Question'
            note='For use only in Landing Pages'
        />
        <x-twill::wysiwyg
            name='answer'
            label='Answer'
            note='For use only in Landing Pages'
        />
    </div>
