@extends('twill.repeaters-shared._experience_image')

@section('caption')
    <x-twill::wysiwyg
        name='caption'
        label='Caption'
        :maxlength='500'
    />
@endsection
