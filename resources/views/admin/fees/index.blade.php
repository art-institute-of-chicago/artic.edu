@extends('cms-toolkit::layouts.main')

@section('content')
    {{ Form::model($form_fields, [
        'method' => 'POST',
        'url' => route('admin.landing.visit.fees.update'),
        'class' => "simple_form",
        'novalidate' => "novalidate",
        'accept-charset' => "UTF-8",
    ]) }}

    @foreach($feeAges as $feeAge)
        <section class="box box-background">
            <header class="header_small">
                <h3><b>{{$feeAge->title}}</b></h3>
            </header>

            <section class="box">
                @foreach($feeCategories as $feeCategory)
                    @formField('input', [
                        'field_name' => $feeCategory->title,
                        'field' => 'price['. $feeAge->id .']['. $feeCategory->id .']'
                    ])
                @endforeach
            </section>
        </section>
    @endforeach
@stop

@section('footer')
    @can('edit')
        <ul>
            <li><input type="submit" class="btn btn-primary"></li>
            <li><a href="{{ Request::url() }}" class="btn">Cancel</a></li>
        </ul>
    @endcan
    </form>
@stop
