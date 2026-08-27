<section class="custom">
    @component('components.molecules._m-header-block')
        {{ $title }}
    @endcomponent

    <div class="{{$landingPageType}}-subnav">
        @include('components.molecules._m-auto-subnav', ['subnav' => $subnav])
    </div>
</section>
