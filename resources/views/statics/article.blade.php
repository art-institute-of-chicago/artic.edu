@extends('layouts.app')

@section('content')

<article class="o-article">

  <header class="o-article__header o-article__header--basic">
    @component('components.atoms._title')
        @slot('tag','h1')
        @slot('font','f-headline')
        Making Place: the Architecture of David Adjaye
    @endcomponent
    @component('components.atoms._date')
        @slot('tag','p')
        September 19 2015 - January 3 2016
    @endcomponent
    @component('components.atoms._type')
        @slot('tag','p')
        Exhibition
    @endcomponent
  </header>

  <div class="o-article__primary">
    <hr>
    <p>
        @component('components.atoms._btn')
            @slot('variation', 'btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--share--24')
        @endcomponent
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--print--24')
        @endcomponent
    </p>
    <hr>
    <p class="f-secondary"><svg class="icon--location" aria-hidden="true"><use xlink:href="#icon--location" /></svg> Galleries 182-184</p>
  </div>

  <div class="o-article__secondary">
    <hr class="u-hide@medium+">
    <p>
        @component('components.atoms._btn')
            @slot('variation', 'btn--full')
            @slot('tag', 'a')
            @slot('href', '#')
            Buy tickets
        @endcomponent
        <br>
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary btn--full')
            @slot('tag', 'a')
            @slot('href', '#')
            Become a member
        @endcomponent
    </p>
    <p class="f-secondary">Exhibitions are free with museum admission.</p>
  </div>

  <div class="o-article__body" data-behavior="articleBodyInViewport">
    <hr>
    <p class="f-deck">Deck sit amet, consectetur adipiscing elit. Curabitur magna neque, laoreet at tristique et, dignissim condimentum enim. Proin cursus diam nec nibh fermentum, eget consequat arcu efficitur</p>
    <p class="f-body">Vivamus lobortis mauris felis, vel venenatis mi viverra sed. Aliquam fermentum eros quis odio gravida, ac vulputate felis pretium. Sed in pellentesque arcu. Pellentesque non nisi eros. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam eu justo at mi rutrum mattis. Proin cursus fermentum velit sit amet congue. Etiam consectetur ultricies nisi vel convallis. Ut auctor pellentesque efficitur.</p>
    <h4 class="f-module-title-2">Module title 2</h4>
    <p class="f-body">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
    <h4 class="f-module-title-1">Module title 1</h4>
    <p class="f-body">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
    <h4 class="f-module-title-2">Module title 2</h4>
    <h4 class="f-module-title-1">Module title 1</h4>
    <p class="f-body">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
    @component('components.molecules._m-media')
        @slot('type','image')
        @slot('media', array('src' => 'http://placehold.dev.area17.com/image/600x400'))
        @slot('captionTitle', 'Caption Title')
        @slot('caption', 'In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris.')
    @endcomponent
    @component('components.molecules._m-media')
        @slot('type','video')
        @slot('media', array('src' => '/test/feature-1.mp4', 'poster' => '/test/feature-1.jpg'))
        @slot('captionTitle', 'Caption Title')
        @slot('caption', 'In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris.')
    @endcomponent
    @component('components.molecules._m-media')
        @slot('variation','m')
        @slot('type','video')
        @slot('media', array('src' => '/test/feature-1.mp4', 'poster' => '/test/feature-1.jpg'))
        @slot('captionTitle', 'Caption Title')
        @slot('caption', 'In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris.')
    @endcomponent
    @component('components.molecules._m-media')
        @slot('variation','l')
        @slot('type','video')
        @slot('media', array('src' => '/test/feature-1.mp4', 'poster' => '/test/feature-1.jpg'))
        @slot('captionTitle', 'Caption Title')
        @slot('caption', 'In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris.')
    @endcomponent
    @component('components.atoms._quote')
        In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris.
    @endcomponent

    @component('components.organisms._o-row-listing')
        @foreach ($timelineEvents as $date)
            @component('components.molecules._m-listing----timeline')
                @slot('date', $date)
            @endcomponent
        @endforeach
    @endcomponent


  </div>

  <div class="o-article__tertiary">
    <p class="o-article__tertiary-titles f-body">
        @component('components.atoms._date')
            @slot('font','f-body')
            Making Place: the Architecture of David Adjaye
        @endcomponent
        <br>
        @component('components.atoms._date')
            September 19 2015 - January 3 2016
        @endcomponent
    </p>
    <p class="o-article__tertiary-actions">
        @component('components.atoms._btn')
            @slot('variation', 'btn--full')
            @slot('tag', 'a')
            @slot('href', '#')
            Buy tickets
        @endcomponent
        <br>
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary btn--full')
            @slot('tag', 'a')
            @slot('href', '#')
            Become a member
        @endcomponent
    </p>
  </div>

    @component('components.atoms._btn')
        @slot('variation', 'btn--icon arrow-link--up o-article__top-link')
        @slot('font', '')
        @slot('icon', 'icon--arrow')
        @slot('behavior', 'topLink')
        @slot('tag', 'a')
        @slot('href', '#a17')
    @endcomponent

</article>

@endsection
