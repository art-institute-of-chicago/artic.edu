@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    Whoops, looks like something went wrong.
@endcomponent

@component('components.molecules._m-intro-block')
    Sorry, something went wrong while trying to do what you wanted.
@endcomponent

<p>
    <a href="/" class="btn f-buttons btn--secondary">To Homepage</a>
    <a href="/search" class="btn f-buttons btn--secondary">Perform a Search</a>
</p>

@endsection
