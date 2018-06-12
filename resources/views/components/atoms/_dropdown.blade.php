<span aria-label="{{ $ariaTitle }}" class="dropdown{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="dropdown">
  <button class="dropdown__trigger {{ $font ?? "f-secondary" }}">{{ $prompt ?? 'Select' }}<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
  <ul class="dropdown__list{{ (isset($listVariation)) ? ' '.$listVariation : '' }} f-secondary" data-dropdown-list>
    @foreach ($options as $option)
      <li{!! (isset($option['active']) and $option['active']) ? ' class="s-active"' : '' !!}><a href="{{ $option['href'] ?? '#' }}"{!! (isset($option['ajaxScrollTarget']) and $option['ajaxScrollTarget']) ? ' data-ajax-scroll-target="'.$option['ajaxScrollTarget'].'"' : '' !!}{!! (!empty($option['ajaxTabTarget'])) ? ' data-ajax-tab-target="'.$option['ajaxTabTarget'].'"' : '' !!}>{!! $option['label'] ?? '' !!}</a></li>
    @endforeach
  </ul>
</span>
