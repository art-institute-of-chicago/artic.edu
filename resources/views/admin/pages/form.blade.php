@extends('cms-toolkit::layouts.resources.form')

@php($with_view_link = false)

@section('form')
    {{ Form::model($form_fields, $form_options) }}
            @formField('hidden', ['field' => 'type'])
            @include('admin.pages.form_' . snake_case(App\Models\Page::$types[$item->type]))
    </section>
@stop

@section('footer')
    @can('edit')
        <ul>
            @if($save ?? true)
                <li><input type="submit" name="finish" value="Save" class="btn btn-primary"></li>
                <li><a href="{{ Request::url() }}" class="btn">Cancel</a></li>
            @endif
            @if(isset($liveSiteUrl))
                <li class="float-right"><a class="btn" target="_blank" href="{{ $liveSiteUrl }}">Open live site</a></li>
            @endif
    @endcan
    {!! Form::close() !!}
@stop
