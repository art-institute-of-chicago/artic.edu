@extends('layouts.app')

@section('content')

    <article>
        <header>
            @component('components.molecules._m-header-block')
                @slot('tag', 'div')
                {{ $title }}
            @endcomponent

            @component('components.molecules._m-intro-block')
                @slot('variation', 'm-intro-block--tight')
                {!! $intro !!}
            @endcomponent
        </header>

        @component('components.molecules._m-links-bar')
            @slot('variation', 'm-links-bar--tabs')
            @slot('overflow', true)
            @slot('linksPrimary', $linksBar)
        @endcomponent

        @component('components.molecules._m-post-hero')
            @slot('post', $hero)
        @endcomponent

        @component('components.organisms._o-grid-listing')
            @slot('cols_medium','2')
            @slot('cols_large','2')
            @slot('cols_xlarge','2')
            @slot('tag', 'div')
        @endcomponent

        @component('components.atoms._hr')
        @endcomponent

        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
            @slot('cols_large','3')
            @slot('cols_xlarge','3')
            @foreach ($items as $item)
                @component('components.molecules._m-listing----multi-links')
                    @slot('variation', 'm-listing--row@small m-listing--row@medium')
                    @slot('item', $item)
                @endcomponent
            @endforeach
        @endcomponent

        <section>
            @component('components.molecules._m-title-bar')
                @slot('links', array(array('label' => 'More about Study rooms', 'href' => '#')))
                Study Rooms
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
                @slot('cols_large','3')
                @slot('cols_xlarge','3')

                @foreach ($studyRooms as $item)
                    @component('components.molecules._m-listing----multi-links')
                        @slot('variation', 'm-listing--row@small m-listing--row@medium')
                        @slot('item', $item)
                    @endcomponent
                @endforeach
            @endcomponent
        </section>
    </article>

@endsection
