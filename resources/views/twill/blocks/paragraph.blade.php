@twillBlockTitle('Paragraph')
@twillBlockIcon('text')

<x-twill::wysiwyg
    name='paragraph'
    label='Paragraph'
    note="Wrap footnote text with [ref]...[/ref]"
    type="quill" {{-- Twill's use of the Tip Tap editor doesn't support the 'superscript' toolbar option out of the box. So use quill until it does --}}
    :toolbar-options="[ ['header' => 2], ['header' => 3], ['header' => 4], 'bold', 'italic', 'underline', 'strike', 'link', 'list-ordered', 'list-unordered', ['script' => 'super'] ]"
/>
