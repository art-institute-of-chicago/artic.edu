@twillBlockTitle('External search bar')
@twillBlockIcon('text')

<x-twill::input
    name='header'
    label='Header'
    note='Not shown if omitted'
/>

<x-twill::input
    name='placeholder'
    label='Placeholder text'
    note='Shown inside search bar'
/>

<x-twill::input
    name='url_template'
    label='Search URL template'
    note='Use {query} to specify which part should be replaced'
/>
