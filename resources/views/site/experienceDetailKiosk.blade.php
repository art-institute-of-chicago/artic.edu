@extends('layouts.kiosk')

@section('content')
    <section class="o-closer-look" data-behavior="closerLook">
        <script type="application/json" data-closerLook-contentBundle>
            {!! json_encode($experience->contentBundle) !!}
        </script>
        <script type="application/json" data-closerLook-assetLibrary>
            {!! json_encode($experience->assetLibrary) !!}
        </script>
    </section>
@endsection
