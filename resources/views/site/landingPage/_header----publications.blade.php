<h2 style="margin-top: 84px" class="title f-display-1">Publications</h2>
<hr>
@if (isset($subnav) && (count($subnav) > 0))
    <div class="{{$landingPageType}}-subnav">
        @include('components.molecules._m-auto-subnav', ['subnav' => $subnav])
    </div>
@endif