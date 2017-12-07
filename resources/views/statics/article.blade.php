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
            @slot('behavior','printPage')
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
    @component('components.blocks._text')
        @slot('font','f-deck')
        Deck sit amet, consectetur adipiscing elit. Curabitur magna neque, laoreet at tristique et, dignissim condimentum enim. Proin cursus diam nec nibh fermentum, eget consequat arcu efficitur
    @endcomponent
    @component('components.blocks._text')
        Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.
    @endcomponent
    @component('components.blocks._text')
        @slot('font','f-module-title-2')
        @slot('tag','h4')
        Title ipsum dolor sit amet
    @endcomponent
    @component('components.blocks._text')
        Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.
    @endcomponent
    @component('components.blocks._text')
        @slot('font','f-subheading-1')
        @slot('tag','h4')
        Title ipsum dolor sit amet
    @endcomponent
    @component('components.blocks._text')
        Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.
    @endcomponent
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
            @component('components.blocks._text')
                @slot('font','f-caption')
                Morbi eleifend massa nibh, sit amet ultricies turpis convallis id. Vestibulum ac vehicula felis, id facilisis erat. Sed a condimentum libero, ut sodales mi.
            @endcomponent
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
            @component('components.blocks._text')
                @slot('font','f-caption')
                Morbi eleifend massa nibh, sit amet ultricies turpis convallis id. Vestibulum ac vehicula felis, id facilisis erat. Sed a condimentum libero, ut sodales mi.
            @endcomponent
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
                @component('components.blocks._text')
                    @slot('font','f-subheading-1')
                    @slot('tag','h4')
                    Title ipsum dolor sit amet
                @endcomponent
                @component('components.blocks._text')
                    Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.
                @endcomponent
            </div>
        </div>

        <h3 id="tab2" class="o-accordion__trigger f-module-title-2" aria-selected="false" aria-controls="panel2" aria-expanded="false" role="tab" tabindex="0">
            Morbi vitae ullamcorper tellus
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </h3>
        <div id="panel2" class="o-accordion__panel" aria-labelledby="tab2" aria-hidden="true" role="tabpanel">
            <div class="o-accordion__panel-content">
                @component('components.blocks._text')
                    In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.
                @endcomponent
                @component('components.blocks._text')
                    Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus.
                @endcomponent
            </div>
        </div>

        <h3 id="tab3" class="o-accordion__trigger f-module-title-2" aria-selected="false" aria-controls="panel3" aria-expanded="false" role="tab" tabindex="0">
            Quisque id sollicitudin
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </h3>
        <div id="panel3" class="o-accordion__panel" aria-labelledby="tab3" aria-hidden="true" role="tabpanel">
            <div class="o-accordion__panel-content">
                @component('components.blocks._text')
                    Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.
                @endcomponent
            </div>
        </div>
    </div>

    @component('components.blocks._text')
        Some related exhibitions
    @endcomponent

    @component('components.organisms._o-row-listing')
        @foreach ($relatedExhibitions as $exhibition)
            @component('components.molecules._m-listing----exhibition-row')
                @slot('variation', 'm-listing--inline')
                @slot('exhibition', $exhibition)
            @endcomponent
        @endforeach
    @endcomponent

    @component('components.blocks._text')
        Some related events
    @endcomponent

    @component('components.organisms._o-row-listing')
        @foreach ($relatedEvents as $event)
            @component('components.molecules._m-listing----event-row')
                @slot('variation', 'm-listing--inline')
                @slot('event', $event)
            @endcomponent
        @endforeach
    @endcomponent

    @component('components.blocks._text')
        Some related products
    @endcomponent

    @component('components.organisms._o-row-listing')
        @foreach ($relatedProducts as $product)
            @component('components.molecules._m-listing----product-row')
                @slot('variation', 'm-listing--inline m-listing--inline-feature')
                @slot('product', $product)
            @endcomponent
        @endforeach
    @endcomponent

    @component('components.blocks._text')
        @slot('font','f-body-editorial')
        @component('components.blocks._text')
            @slot('font','f-dropcap-editorial')
            @slot('tag','span')
            S
        @endcomponent
        it amet, consectetur adipiscing elit. Curabitur magna neque, laoreet at tristique et, dignissim condimentum enim. Proin cursus diam nec nibh fermentum, eget consequat arcu efficitur nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam eu justo at mi rutrum mattis.
    @endcomponent

    @component('components.blocks._inline-aside')
        @slot('title', 'Related Exhibition')
        @component('components.molecules._m-listing----exhibition-row')
            @slot('tag', 'p')
            @slot('variation', 'm-listing--inline')
            @slot('exhibition', $relatedExhibition)
        @endcomponent
    @endcomponent

    @component('components.blocks._text')
        @slot('font','f-body-editorial')
        Vivamus lobortis mauris felis, vel venenatis mi viverra sed. Aliquam fermentum eros quis odio gravida, ac vulputate felis pretium. Sed in pellentesque arcu. Pellentesque non nisi eros. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam eu justo at mi rutrum mattis. Proin cursus fermentum velit sit amet congue. Etiam consectetur ultricies nisi vel convallis. Ut auctor pellentesque efficitur. Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.
    @endcomponent

    @component('components.blocks._inline-aside')
        @slot('title', 'Related Event')
        @component('components.molecules._m-listing----event-row')
            @slot('tag', 'p')
            @slot('variation', 'm-listing--inline')
            @slot('titleFont', 'f-list-2');
            @slot('event', $relatedEvent)
        @endcomponent
    @endcomponent

    @component('components.blocks._text')
        @slot('font','f-body-editorial')
        Vivamus lobortis mauris felis, vel venenatis mi viverra sed. Aliquam fermentum eros quis odio gravida, ac vulputate felis pretium. Sed in pellentesque arcu. Pellentesque non nisi eros. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam eu justo at mi rutrum mattis. Proin cursus fermentum velit sit amet congue. Etiam consectetur ultricies nisi vel convallis. Ut auctor pellentesque efficitur. Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.
    @endcomponent

    @component('components.blocks._inline-aside')
        @slot('title', 'Related Exhibitions')
        @component('components.organisms._o-row-listing')
            @foreach ($relatedExhibitions as $exhibition)
                @component('components.molecules._m-listing----exhibition-row')
                    @slot('variation', 'm-listing--inline')
                    @slot('exhibition', $exhibition)
                @endcomponent
            @endforeach
        @endcomponent
    @endcomponent

    @component('components.blocks._text')
        @slot('font','f-body-editorial')
        Nam quis lorem vitae ex imperdiet aliquet a eu quam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer eget sem sit amet nibh luctus hendrerit eu et enim. Curabitur viverra elementum tempus. Praesent luctus lectus sit amet leo tempus, vel luctus metus cursus. Nullam sit amet dui a nibh elementum pulvinar ut egestas nisi. Donec hendrerit malesuada lectus, non viverra justo cursus ac. Nunc gravida, leo sit amet viverra varius, lacus arcu euismod lorem, varius iaculis odio lorem in ex. Cras dolor sapien, vehicula ut vulputate maximus, dapibus quis metus. Aenean molestie facilisis odio eu scelerisque. Praesent luctus ultrices turpis sed placerat. Curabitur sit amet urna iaculis, congue arcu faucibus, venenatis purus. Nunc nunc felis, ultricies facilisis suscipit a, venenatis eu tellus. Morbi tellus ipsum, ultrices et vehicula a, elementum at sapien. Quisque nec lorem tellus. Vestibulum dapibus non turpis sit amet tempor.
    @endcomponent

    @component('components.blocks._inline-aside')
        @slot('title', 'Featured Product')
        @component('components.molecules._m-listing----product-row')
            @slot('tag', 'p')
            @slot('variation', 'm-listing--inline m-listing--inline-feature')
            @slot('product', $relatedProduct)
        @endcomponent
    @endcomponent

    @component('components.blocks._text')
        @slot('font','f-body-editorial')
        Ut et urna sagittis, efficitur velit at, mattis erat. Proin fringilla gravida pellentesque. Sed tortor odio, consequat eget urna quis, dapibus bibendum nisl. Phasellus quis dapibus leo, id sodales libero. Vivamus sodales ante non purus mattis, ac scelerisque tortor maximus. Donec tristique magna orci, ac sollicitudin leo molestie a. Duis mattis, massa laoreet tincidunt cursus, mi libero faucibus nibh, et porta tellus felis ut enim. Nunc dapibus venenatis leo, sit amet viverra ipsum cursus ut. Pellentesque pretium, ante non egestas facilisis, felis leo venenatis neque, nec pulvinar magna sapien non nibh. Donec at diam quam. Integer varius nulla urna, hendrerit semper velit pellentesque quis. Sed ut tristique urna, ut vulputate urna. Sed eu tincidunt orci. In aliquet gravida dolor quis placerat. Vestibulum a mauris in leo ornare elementum at sit amet augue.
    @endcomponent

    @component('components.molecules._m-cta-banner----become-a-member')
    @endcomponent

    @component('components.molecules._m-aside-newsletter')
        @slot('variation','m-aside-newsletter--wide')
        @slot('btnFont','f-tag')
    @endcomponent

    @component('components.molecules._m-aside-newsletter')
    @endcomponent

    @component('components.blocks._inline-aside')
        @component('components.molecules._m-aside-newsletter')
            @slot('variation','m-aside-newsletter--inline')
            @slot('placeholder','Email Address')
        @endcomponent
    @endcomponent

    @component('components.blocks._text')
        @slot('font','f-body-editorial')
        Ut et urna sagittis, efficitur velit at, mattis erat. Proin fringilla gravida pellentesque. Sed tortor odio, consequat eget urna quis, dapibus bibendum nisl. Phasellus quis dapibus leo, id sodales libero. Vivamus sodales ante non purus mattis, ac scelerisque tortor maximus. Donec tristique magna orci, ac sollicitudin leo molestie a. Duis mattis, massa laoreet tincidunt cursus, mi libero faucibus nibh, et porta tellus felis ut enim. Nunc dapibus venenatis leo, sit amet viverra ipsum cursus ut. Pellentesque pretium, ante non egestas facilisis, felis leo venenatis neque, nec pulvinar magna sapien non nibh. Donec at diam quam. Integer varius nulla urna, hendrerit semper velit pellentesque quis. Sed ut tristique urna, ut vulputate urna. Sed eu tincidunt orci. In aliquet gravida dolor quis placerat. Vestibulum a mauris in leo ornare elementum at sit amet augue.
    @endcomponent

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
