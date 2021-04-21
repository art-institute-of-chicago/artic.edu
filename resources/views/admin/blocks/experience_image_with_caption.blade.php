@extends('admin.blocks.experience_image')

@twillBlockTitle('title')

@section('caption')
    @formField('wysiwyg', [
        'name' => 'caption',
        'label' => 'Caption',
        'maxlength' => 500,
    ])
@endsection
