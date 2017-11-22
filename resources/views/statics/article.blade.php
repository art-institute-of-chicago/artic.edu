@extends('layouts.app')

@section('content')

<article class="o-article">

  <header class="o-article__header">
    <h1 class="f-display-2">Display 2</h1>
    <h2 class="f-display-1">Display 1</h2>
    <h3 class="f-headline">Headline</h3>
  </header>

  <div class="o-article__body">
    <p class="f-deck">Deck sit amet, consectetur adipiscing elit. Curabitur magna neque, laoreet at tristique et, dignissim condimentum enim. Proin cursus diam nec nibh fermentum, eget consequat arcu efficitur</p>
    <p class="f-body-editorial">Vivamus lobortis mauris felis, vel venenatis mi viverra sed. Aliquam fermentum eros quis odio gravida, ac vulputate felis pretium. Sed in pellentesque arcu. Pellentesque non nisi eros. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam eu justo at mi rutrum mattis. Proin cursus fermentum velit sit amet congue. Etiam consectetur ultricies nisi vel convallis. Ut auctor pellentesque efficitur.</p>
    <h4 class="f-module-title-2">Module title 2</h4>
    <p class="f-body-editorial">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
    <h4 class="f-module-title-1">Module title 1</h4>
    <p class="f-body-editorial">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
    <h4 class="f-module-title-2">Module title 2</h4>
    <h4 class="f-module-title-1">Module title 1</h4>
    <p class="f-body-editorial">Sed nulla leo, tempus id imperdiet a, porttitor vel neque. Morbi vitae ullamcorper tellus. Cras molestie tempor lorem sed aliquet. Proin quis purus in sem ultrices tempus a et tellus. In tempor, velit quis finibus maximus, felis magna rutrum arcu, ut fermentum est libero sed mauris. Quisque id sollicitudin erat, non faucibus dolor. Praesent lobortis varius dignissim.</p>
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
  </div>

  <div class="o-article__asides">
    <p>
        <button class="btn btn--icon"><svg class="icon--share--24"><use xlink:href="#icon--share--24" /></svg></button>
        <button class="btn btn--quaternary btn--icon"><svg class="icon--print--24"><use xlink:href="#icon--print--24" /></svg></button>
    </p>
    <ul>
        <li><a href="#" class="btn">Buy tickets</a></li>
        <li><a href="#" class="btn btn--secondary">Become a member</a></li>
    </ul>
    <p class="f-secondary">Exhibitions are free with Museum admission</p>
  </div>

</article>

@endsection
