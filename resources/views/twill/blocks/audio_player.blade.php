@twillBlockTitle('Audio Player')
@twillBlockIcon('image')

<x-twill::files
    name='audio_file'
    label='Audio file'
    note='Upload a .mp3 file'
/>

<x-twill::input
    name='title_display'
    label='Title'
    note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
/>

<x-twill::wysiwyg
    name='transcript'
    label='Transcript'
    :toolbar-options="[ 'italic', 'link' ]"
/>

<x-twill::wysiwyg
    name='caption_title'
    label='Caption title'
    :toolbar-options="[ 'italic', 'link' ]"
/>

<x-twill::wysiwyg
    name='caption'
    label='Caption'
    note='Max 300 characters'
    :maxlength='300'
    :toolbar-options="[ 'italic', 'link' ]"
/>
