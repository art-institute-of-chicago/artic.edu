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
    <h4 class="f-subheading-1">Module title 1</h4>
    <p class="f-body">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
    @component('components.molecules._m-media')
        @slot('type','image')
        @slot('media', array('src' => 'http://placehold.dev.area17.com/image/600x400'))
        @slot('caption', 'In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris.')
    @endcomponent
    @component('components.molecules._m-media')
        @slot('type','video')
        @slot('media', array('src' => '/test/feature-1.mp4', 'poster' => '/test/feature-1.jpg'))
        @slot('caption', 'In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris.')
    @endcomponent
    @component('components.molecules._m-media')
        @slot('variation','m')
        @slot('type','video')
        @slot('media', array('src' => '/test/feature-1.mp4', 'poster' => '/test/feature-1.jpg'))
        @slot('caption', 'In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris.')
    @endcomponent
    @component('components.molecules._m-media')
        @slot('variation','l')
        @slot('type','video')
        @slot('media', array('src' => '/test/feature-1.mp4', 'poster' => '/test/feature-1.jpg'))
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

    @component('components.molecules._m-link-list')
        @slot('links', array(array('text' => 'Quis finibus maximus', 'href' => '#'), array('text' => 'Ut fermentum est', 'href' => '#', 'icon' => 'icon--new-window'), array('text' => 'In tempor velit', 'href' => '#', 'icon' => 'icon--new-window')));
    @endcomponent

    <div class="o-gallery o-gallery--mosaic">
        <h3 class="o-gallery__title f-module-title-2">Mosaic Gallery</h3>
        <div class="o-gallery__caption">
            <hr>
            <p class="f-caption">Morbi eleifend massa nibh, sit amet ultricies turpis convallis id. Vestibulum ac vehicula felis, id facilisis erat. Sed a condimentum libero, ut sodales mi.</p>
            @component('components.atoms._btn')
                @slot('variation', 'btn--quinary btn--icon o-gallery__share')
                @slot('font', '')
                @slot('icon', 'icon--share--24')
            @endcomponent
        </div>
        <div class="o-gallery__media">
            @component('components.molecules._m-media')
                @slot('type','image')
                @slot('variation', 'gallery')
                @slot('media', array('src' => 'http://placehold.dev.area17.com/image/600x400', "width" => 600, "height" => 400))
                @slot('captionTitle', 'In tempor')
                @slot('caption', 'Velit quis finibus maximus.')
            @endcomponent

            @component('components.molecules._m-media')
                @slot('type','image')
                @slot('variation', 'gallery')
                @slot('media', array('src' => 'http://placehold.dev.area17.com/image/400x600', "width" => 400, "height" => 600)))
                @slot('captionTitle', 'Felis magna rutrum')
                @slot('caption', 'Fermentum est libero sed mauris.')
            @endcomponent

            @component('components.molecules._m-media')
                @slot('type','image')
                @slot('variation', 'gallery')
                @slot('media', array("src" => "http://placehold.dev.area17.com/image/524x750", "width" => 524, "height" => 750))
                @slot('captionTitle', 'In tempor')
                @slot('caption', 'Velit quis finibus maximus.')
            @endcomponent

            @component('components.molecules._m-media')
                @slot('type','image')
                @slot('variation', 'gallery')
                @slot('media', array("src" => "http://placehold.dev.area17.com/image/651x500", "width" => 651, "height" => 500))
                @slot('captionTitle', 'Felis magna rutrum')
                @slot('caption', 'Fermentum est libero sed mauris.')
            @endcomponent
        </div>
    </div>

    <div class="o-gallery o-gallery--slider">
        <h3 class="o-gallery__title f-module-title-2">Slider Gallery</h3>
        <div class="o-gallery__caption">
            <hr>
            <p class="f-caption">Morbi eleifend massa nibh, sit amet ultricies turpis convallis id. Vestibulum ac vehicula felis, id facilisis erat. Sed a condimentum libero, ut sodales mi.</p>
            @component('components.atoms._btn')
                @slot('variation', 'btn--quinary btn--icon o-gallery__share')
                @slot('font', '')
                @slot('icon', 'icon--share--24')
            @endcomponent
        </div>
        <div class="o-gallery__media" data-behavior="dragScroll">
            @component('components.molecules._m-media')
                @slot('type','image')
                @slot('variation', 'gallery')
                @slot('media', array('src' => 'http://placehold.dev.area17.com/image/600x400', "width" => 600, "height" => 400))
                @slot('captionTitle', 'In tempor')
                @slot('caption', 'Velit quis finibus maximus.')
            @endcomponent

            @component('components.molecules._m-media')
                @slot('type','image')
                @slot('variation', 'gallery')
                @slot('media', array('src' => 'http://placehold.dev.area17.com/image/400x600', "width" => 400, "height" => 600)))
                @slot('captionTitle', 'Felis magna rutrum')
                @slot('caption', 'Fermentum est libero sed mauris.')
            @endcomponent

            @component('components.molecules._m-media')
                @slot('type','image')
                @slot('variation', 'gallery')
                @slot('media', array("src" => "http://placehold.dev.area17.com/image/524x750", "width" => 524, "height" => 750))
                @slot('captionTitle', 'In tempor')
                @slot('caption', 'Velit quis finibus maximus.')
            @endcomponent

            @component('components.molecules._m-media')
                @slot('type','image')
                @slot('variation', 'gallery')
                @slot('media', array("src" => "http://placehold.dev.area17.com/image/651x500", "width" => 651, "height" => 500))
                @slot('captionTitle', 'Felis magna rutrum')
                @slot('caption', 'Fermentum est libero sed mauris.')
            @endcomponent
        </div>
    </div>

    <div class="o-accordion" role="tablist" multiselectable="true" data-behavior="accordion">
        <h3 id="tab1" class="o-accordion__trigger f-module-title-2" aria-selected="true" aria-controls="panel1" aria-expanded="true" role="tab" tabindex="0">
            Lorem Ipsum
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </h3>
        <div id="panel1" class="o-accordion__panel" aria-labelledby="tab1" aria-hidden="false" role="tabpanel">
            <div class="o-accordion__panel-content">
                <h4 class="f-subheading-1">Module title 1</h4>
                <p class="f-body">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
            </div>
        </div>

        <h3 id="tab2" class="o-accordion__trigger f-module-title-2" aria-selected="false" aria-controls="panel2" aria-expanded="false" role="tab" tabindex="0">
            Morbi vitae ullamcorper tellus
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </h3>
        <div id="panel2" class="o-accordion__panel" aria-labelledby="tab2" aria-hidden="true" role="tabpanel">
            <div class="o-accordion__panel-content">
                <p class="f-body">In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
                <p class="f-body">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. </p>
            </div>
        </div>

        <h3 id="tab3" class="o-accordion__trigger f-module-title-2" aria-selected="false" aria-controls="panel3" aria-expanded="false" role="tab" tabindex="0">
            Quisque id sollicitudin
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </h3>
        <div id="panel3" class="o-accordion__panel" aria-labelledby="tab3" aria-hidden="true" role="tabpanel">
            <div class="o-accordion__panel-content">
                <p class="f-body">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
            </div>
        </div>
    </div>

    @component('components.organisms._o-row-listing')
        @foreach ($relatedExhibitions as $exhibition)
            @component('components.molecules._m-listing----exhibition')
                @slot('variation', 'm-listing--inline')
                @slot('titleFont', 'f-list-2');
                @slot('exhibition', $exhibition)
            @endcomponent
        @endforeach
    @endcomponent

    <p class="f-body-editorial"><span class="f-dropcap-editorial">S</span>it amet, consectetur adipiscing elit. Curabitur magna neque, laoreet at tristique et, dignissim condimentum enim. Proin cursus diam nec nibh fermentum, eget consequat arcu efficitur nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam eu justo at mi rutrum mattis.</p>
    <aside class="o-article__inline-aside">
        <hr>
        <h4 class="f-subheading-1">Related Exhibition</h4>
        @component('components.molecules._m-listing----exhibition')
            @slot('tag', 'p')
            @slot('variation', 'm-listing--inline')
            @slot('titleFont', 'f-list-2');
            @slot('exhibition', $relatedExhibition)
        @endcomponent
    </aside>
    <p class="f-body-editorial">Vivamus lobortis mauris felis, vel venenatis mi viverra sed. Aliquam fermentum eros quis odio gravida, ac vulputate felis pretium. Sed in pellentesque arcu. Pellentesque non nisi eros. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam eu justo at mi rutrum mattis. Proin cursus fermentum velit sit amet congue. Etiam consectetur ultricies nisi vel convallis. Ut auctor pellentesque efficitur. Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
    <aside class="o-article__inline-aside">
        <hr>
        <h4 class="f-subheading-1">Related Event</h4>
        @component('components.molecules._m-listing----event-row')
            @slot('tag', 'p')
            @slot('variation', 'm-listing--inline')
            @slot('titleFont', 'f-list-2');
            @slot('event', $relatedEvent)
        @endcomponent
    </aside>
    <p class="f-body-editorial">Vivamus lobortis mauris felis, vel venenatis mi viverra sed. Aliquam fermentum eros quis odio gravida, ac vulputate felis pretium. Sed in pellentesque arcu. Pellentesque non nisi eros. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam eu justo at mi rutrum mattis. Proin cursus fermentum velit sit amet congue. Etiam consectetur ultricies nisi vel convallis. Ut auctor pellentesque efficitur. Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>

    <aside class="o-article__inline-aside">
        <hr>
        <h4 class="f-subheading-1">Related Product</h4>
        @component('components.molecules._m-listing----product')
            @slot('tag', 'p')
            @slot('variation', 'm-listing--inline-product')
            @slot('titleFont', 'f-list-2');
            @slot('product', $relatedProduct)
        @endcomponent
    </aside>

  </div>

  <div class="o-article__tertiary">
    <p class="o-article__tertiary-titles">
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
