{{-- resources/views/site/digitalExplorerDetail.blade.php --}}
@extends(isset($isKiosk) && $isKiosk ? 'layouts.kiosk' : 'layouts.app')

@section('content')
<div class="o-digital-explorer" data-behavior="digitalExplorer"></div>

{{-- Store JSON data in script tags, following the closer-look pattern --}}
<script type="application/json" data-digitalExplorer-contentBundle>
    @json($explorerData)
</script>

@endsection

@push('head')
<link rel="stylesheet" href="{{ asset('explorer/dist/digitalExplorer.css') }}">
@endpush

@section('extra_scripts')
<script src="{{ FrontendHelpers::revAsset('scripts/digitalExplorer.js') }}"></script>
@endsection
