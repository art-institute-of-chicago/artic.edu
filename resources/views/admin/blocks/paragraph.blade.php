@twillBlockTitle('Paragraph')
@twillBlockIcon('text')
@twillBlockComponent('a17-block-paragraph')

@formField('wysiwyg', [
    'name' => 'paragraph',
    'label' => 'Paragraph',
    'note' => 'Wrap footnote text with [ref]...[/ref]',
    'toolbarOptions' => [
        ['header' => 2],
        ['header' => 3],
        'bold', 'italic', 'underline', 'strike', 'link', 'list-ordered', 'list-unordered' ],
])
