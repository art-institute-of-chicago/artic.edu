@twillBlockTitle('Paragraph')
@twillBlockIcon('text')

<x-twill::wysiwyg
    name='paragraph'
    label='Paragraph'
    note="Wrap footnote text with [ref]...[/ref]"
    type="tiptap"
    :toolbar-options="[
        ['header' => [2, 3, 4]],
        'bold',
        'italic',
        'underline',
        'strike',
        'bullet',
        'ordered',
        'link',
    ]"
    :translated='true'
/>
