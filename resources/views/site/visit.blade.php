@extends('layouts.app')

@section('content')

  <section class="o-visit">

    @component('components.molecules._m-media')
      @slot('item', $headerMedia)
      @slot('imageSettings', array(
          'srcset' => array(300,600,1000,1500,3000),
          'sizes' => '100vw',
      ))
    @endcomponent

    @component('components.molecules._m-links-bar')
        @slot('overflow', true)
        @slot('variation', 'm-links-bar--nav-bar')
        @slot('linksPrimary', array(
          array('label' => 'Hours', 'href' => '#hours'),
          array('label' => 'Admission', 'href' => '#admission'),
          array('label' => 'Directions', 'href' => '#directions'),
          array('label' => 'Dining', 'href' => '#dining'),
          array('label' => 'FAQ', 'href' => '#faq'),
          array('label' => 'Tours', 'href' => '#tours'),
          array('label' => 'Families, Teens &amp; Educators', 'href' => '#familes_teens_educators'),
        ))
        @slot('secondaryHtml')
            <li class="m-links-bar__item m-links-bar__item--primary">

            </li>
        @endslot
    @endcomponent

    @component('components.molecules._m-header-block')
        {{ $title }}
    @endcomponent

    @component('components.molecules._m-title-bar')
        @slot('id', 'hours')
        Hours
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-rows')
        @slot('cols_medium','2')
        @slot('cols_large','2')
        @slot('cols_xlarge','2')
        @slot('tag', 'div')

        <div class="o-blocks">
          @component('components.molecules._m-media')
            @slot('item', $hours['media'])
          @endcomponent
        </div>
        <div class="o-blocks">
          @component('components.blocks._text')
              @slot('font','f-list-4')
              {{ $hours['primary'] }}
          @endcomponent
          @component('components.blocks._text')
              @slot('font','f-secondary')
              {{ $hours['secondary'] }}
          @endcomponent
        </div>
    @endcomponent

    @foreach ($hours['sections'] as $section)

      @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-rows')
          @slot('cols_small','2')
          @slot('cols_medium','2')
          @slot('cols_large','2')
          @slot('cols_xlarge','2')
          @slot('tag', 'div')
          <div class="o-blocks">
            @component('components.blocks._text')
                @slot('font','f-list-3')
                @slot('tag','h3')
                @component('components.atoms._arrow-link')
                    @slot('font','f-null')
                    @slot('href', $section['external_link'])
                    {{ $section['title'] }}
                @endcomponent
            @endcomponent
          </div>
          <div class="o-blocks">
            @component('components.blocks._text')
                @slot('font','f-secondary')
                {{ $section['copy'] }}
            @endcomponent
          </div>
      @endcomponent

    @endforeach

  </section>

@endsection
