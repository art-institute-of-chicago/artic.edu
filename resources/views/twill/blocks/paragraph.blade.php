@twillBlockTitle('Paragraph')
@twillBlockIcon('text')

@formField('wysiwyg', [
    'name' => 'paragraph',
    'label' => 'Paragraph',
    'note' => 'Wrap footnote text with [ref]...[/ref]',
    'toolbarOptions' => [
        ['header' => 2],
        ['header' => 3],
        ['header' => 4],
        'bold', 'italic', 'underline', 'strike', 'link', 'list-ordered', 'list-unordered',
        ['script' => 'super'],
    ],
])
