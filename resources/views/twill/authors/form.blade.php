@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::wysiwyg
        name='description'
        label='Description'
        type='textarea'
        :maxlength='1000'
        :rows='6'
        :toolbar-options="[ 'bold', 'italic', 'link', 'strike' ]"
    />

    <x-twill::wysiwyg
        name='list_description'
        label='Listing Description'
        type='textarea'
        note='Used in listings and for social media'
        :maxlength='300'
        :toolbar-options="[ 'italic' ]"
    />

    @formField('medias', [
        'label' => 'Hero Image',
        'name' => 'hero',
        'note' => 'Minimum image width 2000px'
    ])
@stop
