@twillBlockTitle('Paragraph')
@twillBlockIcon('text')

<x-twill::wysiwyg
    name='paragraph'
    label='Paragraph'
    note="Wrap footnote text with [ref]...[/ref]"
    :toolbar-options="[ [ 'header' => [ 2, 3, 4 ] ], 'bold', 'italic', 'underline', 'strike', 'link', 'ordered', 'bullet', 'superscript' ]"
/>
