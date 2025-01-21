@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Table')
@twillBlockIcon('text')

<p>Use Markdown to create the table below. See <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet#tables">tutorial</a>.</p>

<hr>

@formField('select', [
    'name' => 'size',
    'label' => 'Size',
    'placeholder' => 'Select size',
    'default' => ($type === 'digitalPublications' ? 'l' : 's'),
    'disabled' => ($type === 'digitalPublications' ? true : false),
    'options' => [
        [
            'value' => 's',
            'label' => 'Small'
        ],
        [
            'value' => 'l',
            'label' => 'Large'
        ]
    ]
])

<x-twill::input
    name='table_title'
    label='Title'
    note='Optional'
    :maxlength='60'
/>

<x-twill::input
    type='textarea'
    name='table_markdown'
    label='Table (Markdown)'
    note='Limited to one table per block'
    :rows='4'
/>

<x-twill::wysiwyg
    name='table_caption'
    label='Caption'
    note='Optional'
    :toolbar-options="[ ['header' => 3], 'bold', 'italic', 'underline', 'strike', 'link', 'list-ordered', 'list-unordered', ['script' => 'super'] ]"
/>

@formField('checkbox', [
    'name' => 'has_side_header',
    'label' => 'Leftmost column is also a header',
])

@formField('checkbox', [
    'name' => 'allow_word_wrap',
    'label' => 'Allow word wrap in table cells',
])

@formField('checkbox', [
    'name' => 'hide_columns',
    'label' => 'Hide vertical cell borders',
])
