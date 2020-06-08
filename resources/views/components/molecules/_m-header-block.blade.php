@if (isset($breadcrumbs))
      <ul class="m-article-header__breadcrumb" data-blur-clip-to>
        @foreach ($breadcrumbs as $link)
            <li class="f-secondary">
                @component('components.atoms._arrow-link')
                    @slot('font','f-null')
                    @slot('href',$link['href'])
                    {{ $link['label'] }}
                @endcomponent
            </li>
        @endforeach
        <li class="f-secondary">
            @component('components.atoms._link')
                @slot('font','f-null')
                {!! $slot !!}
            @endcomponent
        </li>

      </ul>
  @endif<{{ $tag ?? 'header' }} class="m-header-block">
  <h1 class="title f-display-1"{!! (isset($itemprop)) ? ' itemprop="'.$itemprop.'"' : '' !!}>{!! $slot !!}</h1>
</{{ $tag ?? 'header' }}>
