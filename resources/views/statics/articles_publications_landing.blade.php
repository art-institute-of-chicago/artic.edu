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

        <section>
            @component('components.molecules._m-title-bar')
                @slot('links', array(array('label' => 'Browse all articles', 'href' => '#')))
                @slot('variation', 'm-title-bar--no-hr')
                Art Institute Blog
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            <div class="o-feature-plus-4">
                @component('components.molecules._m-listing----article')
                    @slot('tag', 'p')
                    @slot('titleFont', 'f-list-5')
                    @slot('captionFont', 'f-body-editorial')
                    @slot('variation', 'o-feature-plus-4__feature')
                    @slot('item', $featureHero)
                @endcomponent
                <ul class="o-feature-plus-4__items-1">
                @foreach ($features as $editorial)
                    @if ($loop->index < 2)
                        @component('components.molecules._m-listing----article-minimal')
                            @slot('item', $editorial)
                        @endcomponent
                    @endif
                @endforeach
                </ul>
                <ul class="o-feature-plus-4__items-2">
                @foreach ($features as $editorial)
                    @if ($loop->index > 1)
                        @component('components.molecules._m-listing----article-minimal')
                            @slot('item', $editorial)
                        @endcomponent
                    @endif
                @endforeach
                </ul>
            </div>
        </section>

        <section>
            @component('components.molecules._m-title-bar')
                @slot('links', array(array('label' => 'Browse all digital catalogs', 'href' => '#')))
                Digital Catalogs
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
                @slot('cols_large','3')
                @slot('cols_xlarge','3')
                @foreach ($digitalCatalogs['items'] as $item)
                    @component('components.molecules._m-listing----generic')
                        @slot('variation', 'm-listing--row@small m-listing--row@medium')
                        @slot('item', $item)
                    @endcomponent
                @endforeach
            @endcomponent
        </section>

        <section>
            @component('components.molecules._m-title-bar')
                @slot('links', array(array('label' => 'Browse all printed catalogs', 'href' => '#')))
                Printed Catalogs
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            @component('components.molecules._m-intro-block')
                {!! $printedCatalogs['intro'] !!}
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
                @slot('cols_large','4')
                @slot('cols_xlarge','4')
                @foreach ($printedCatalogs['items'] as $item)
                    @component('components.molecules._m-listing----generic')
                        @slot('variation', 'm-listing--row@small m-listing--row@medium')
                        @slot('item', $item)
                    @endcomponent
                @endforeach
            @endcomponent
        </section>

        <section>
            @component('components.molecules._m-title-bar')
                @slot('links', array(array('label' => 'Browse all articles', 'href' => '#')))
                Scholarly Journals
            @endcomponent

            @component('components.atoms._hr')
            @endcomponent

            <div class="o-feature-plus-4">
                @component('components.molecules._m-listing----article')
                    @slot('tag', 'p')
                    @slot('titleFont', 'f-list-5')
                    @slot('captionFont', 'f-body-editorial')
                    @slot('variation', 'o-feature-plus-4__feature')
                    @slot('item', $journalHero)
                @endcomponent
                <ul class="o-feature-plus-4__items-1">
                @foreach ($journals as $editorial)
                    @if ($loop->index < 2)
                        @component('components.molecules._m-listing----article-minimal')
                            @slot('item', $editorial)
                        @endcomponent
                    @endif
                @endforeach
                </ul>
                <ul class="o-feature-plus-4__items-2">
                @foreach ($journals as $editorial)
                    @if ($loop->index > 1)
                        @component('components.molecules._m-listing----article-minimal')
                            @slot('item', $editorial)
                        @endcomponent
                    @endif
                @endforeach
                </ul>
            </div>
        </section>
    </article>


@endsection
