<div aria-label="{{ $ariaTitle }}" class="dropdown{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="dropdown">
  <h2><button class="dropdown__trigger {{ $font ?? "f-secondary" }}" aria-expanded="false" id="h-select-language">{{ $prompt ?? 'Select' }}<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button></h2>
  <ul class="dropdown__list{{ (isset($listVariation)) ? ' '.$listVariation : '' }} f-secondary" data-dropdown-list aria-labelledby="h-select-language">
    @foreach ($options as $option)
        <li{!! (isset($option['active']) and $option['active']) ? ' class="s-active"' : '' !!}><a href="{{ $option['href'] ?? '#' }}"{!! (isset($option['ajaxScrollTarget']) and $option['ajaxScrollTarget']) ? ' data-ajax-scroll-target="'.$option['ajaxScrollTarget'].'"' : '' !!}{!! (!empty($option['ajaxTabTarget'])) ? ' data-ajax-tab-target="'.$option['ajaxTabTarget'].'"' : '' !!}{!! (isset($link['gtmAttributes'])) ? ' '.$link['gtmAttributes'].'' : '' !!}{!! (isset($option['lang']) and $option['lang']) ? ' lang="'.$option['lang'].'"' : '' !!}>{!! $option['label'] ?? '' !!}</a></li>
    @endforeach
  </ul>
</div>
