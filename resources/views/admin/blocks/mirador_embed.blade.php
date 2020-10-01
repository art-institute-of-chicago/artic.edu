@formField('input', [
	'type' => 'number',
	'name' => 'objectId',
	'label' => 'Object ID',
	'note' => 'Enter object ID to obtain manifest dynamically.'
])
		
@formField('files', [
	'name' => 'upload_manifest_file',
	'label' => 'Alternative manifest file',
	'note' => 'Upload a .json file'
])