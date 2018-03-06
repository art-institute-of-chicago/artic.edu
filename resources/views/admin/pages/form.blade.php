@extends('cms-toolkit::layouts.form')

@include('admin.pages.form_' . snake_case(App\Models\Page::$types[$item->type]))
