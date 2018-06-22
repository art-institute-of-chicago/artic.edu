@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    Looking for something?
@endcomponent

@component('components.molecules._m-intro-block')
    Sorry, whatever you are looking for is no longer here or you typed in the wrong URL. Please double-check and try again.
@endcomponent

<p>
    <a href="/" class="btn f-buttons btn--secondary">To Homepage</a>
    <a href="/search" class="btn f-buttons btn--secondary">Perform a Search</a>
</p>

@endsection
