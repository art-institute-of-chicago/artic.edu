<{{ $tag or 'header' }} class="m-article-header m-article-header--feature{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="blurMyBackground">
  <div class="m-article-header__img" data-blur-img>
      @if ($img)
        @component('components.atoms._img')
            @slot('image', $img)
            @slot('settings', array(
                'srcset' => array(300,600,1000,1500,3000),
                'sizes' => '100vw',
            ))
        @endcomponent
      @endif
  </div>
  <div class="m-article-header__text" data-blur-clip-to>
      @if (isset($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-headline')
            @slot('itemprop','name')
            {{ $title }}
        @endcomponent
      @endif
      @if (isset($formattedDate))
        @component('components.atoms._date')
            {!! $formattedDate !!}
        @endcomponent
      @elseif (empty($dateStart) and empty($dateEnd))
      @elseif (empty($dateEnd) and !empty($dateStart))
           @component('components.atoms._date')
            @slot('tag','p')
            <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j, Y') }}</time>
            @endcomponent
      @elseif (empty($dateStart))
      @elseif ($dateStart and $dateEnd)
        @component('components.atoms._date')
            @slot('tag','p')
            @if($dateStart->format("Y") == $dateEnd->format("Y"))
            <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j') }}</time>&ndash;<time datetime="{{ $dateEnd->format("Y-m-d") }}" itemprop="endDate">{{ $dateEnd->format('M j, Y') }}</time>
            @else
            <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j, Y') }}</time>&ndash;<time datetime="{{ $dateEnd->format("Y-m-d") }}" itemprop="endDate">{{ $dateEnd->format('M j, Y') }}</time>
            @endif
        @endcomponent
      @elseif (isset($date))
        @component('components.atoms._date')
            @slot('tag','p')
            <time datetime="{{ $date->format("Y-m-d") }}" itemprop="startDate">{{ $date->format('F j, Y') }}</time>
        @endcomponent
      @endif
      @if (isset($type))
        @component('components.atoms._type')
            @slot('tag','p')
            {{ $type }}
        @endcomponent
      @endif
      @if ((isset($credit) and !empty($credit)) or ($img and isset($img['credit']) and $img['credit'] !== ""))
        @if (isset($creditUrl))
            <a href="{{ $creditUrl ?? $img['creditUrl'] }}" class="m-article-header__info-trigger">
                <svg class="icon--info-i" aria-label="Image credit"><use xlink:href="#icon--info-i" /></svg>
            </a>
        @else
            <button class="m-article-header__info-trigger" id="image-credit-trigger" aria-selected="false" aria-controls="image-credit" aria-expanded="false" data-behavior="imageInfo">
              <svg class="icon--info-i" aria-label="Image credit"><use xlink:href="#icon--info-i" /></svg>
            </button>
            <div class="m-article-header__info" id="image-credit" aria-labelledby="image-info-trigger" aria-hidden="true" role="Tooltip">
              <div class="f-caption">{!! $credit ?? $img['credit'] !!}</div>
            </div>
        @endif
      @endif
  </div>
</{{ $tag or 'header' }}>
