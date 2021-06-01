@extends('admin.repeaters-shared._experience_image')

@section('caption')
    @formField('wysiwyg', [
        'name' => 'caption',
        'label' => 'Caption',
        'maxlength' => 500,
    ])
@endsection
