@formField('files', [
    'name' => 'vtour_xml_file',
    'label' => 'Virtual tour XML file',
    'note' => 'Upload a .xml file'
])

@formField('wysiwyg', [
    'name' => 'caption_title',
    'label' => 'Caption title',
    'toolbarOptions' => [
    'italic',
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

