@extends('layouts.app')

@section('content')

    <h1 class="f-headline">Fonts:</h1>
    <hr>
    <dl>
    @foreach ($classes as $class)
        <dt class="f-body">.{{ $class }}:</dt>
        <dd class="{{ $class }}">
            <dl>
            @foreach ($elements as $element)
                <dt class="f-secondary">&lt;{{ $element }}&gt;:</dt>
                <dd>
                    <{{ $element }}>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sed venenatis dui.
                    </{{ $element }}
                </dd>
            @endforeach
            </dl>
        </dd>
        <hr>
    @endforeach
    </dl>

@endsection
