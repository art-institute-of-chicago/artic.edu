@twillBlockTitle('Paragraph')
@twillBlockIcon('text')

<x-twill::wysiwyg
    name='paragraph'
    label='Paragraph'
    note='Wrap footnote text with [ref]...[/ref]'
    :toolbar-options="[ ['header' => 2], ['header' => 3], ['header' => 4], 'bold', 'italic', 'underline', 'strike', 'link', 'list-ordered', 'list-unordered', ['script' => 'super'] ]"
/>
