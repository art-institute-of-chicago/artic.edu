@extends('cms-toolkit::layouts.form')

@section('contentFields')
    <input type="hidden" name="type" value="{{ $item->type }}">
    @include('admin.pages.form_' . snake_case(App\Models\Page::$types[$item->type]))
@stop
