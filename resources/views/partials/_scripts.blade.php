<script src="{{FrontendHelpers::revAsset('scripts/app.js')}}"></script>

@if (!config('aic.disable_extra_scripts'))
    @yield('extra_scripts')
@endif
