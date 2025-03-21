@if (isset($subnav) && (count($subnav) > 0))
    <div class="stories-subnav">
        @include('components.molecules._m-auto-subnav', ['subnav' => $subnav])
    </div>
@endif