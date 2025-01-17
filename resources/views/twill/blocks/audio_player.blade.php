@twillBlockTitle('Audio Player')
@twillBlockIcon('image')

@formField('files', [
    'name' => 'audio_file',
    'label' => 'Audio file',
    'note' => 'Upload a .mp3 file',
])

@formField('input', [
    'name' => 'title_display',
    'label' => 'Title',
    'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
])

@formField('wysiwyg', [
    'name' => 'transcript',
    'label' => 'Transcript',
    'toolbarOptions' => [
        'italic', 'link'
    ],
])

@formField('wysiwyg', [
    'name' => 'caption_title',
    'label' => 'Caption title',
    'toolbarOptions' => [
        'italic', 'link',
    ],
])

@formField('wysiwyg', [
    'name' => 'caption',
    'label' => 'Caption',
    'maxlength' => 300,
    'note' => 'Max 300 characters',
    'toolbarOptions' => [
        'italic', 'link',
    ],
])
