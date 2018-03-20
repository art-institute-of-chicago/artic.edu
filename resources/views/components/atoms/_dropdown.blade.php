<span aria-title="{{ $ariaTitle }}" class="dropdown{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="dropdown"{{ (isset($hoverable)) ? ' data-dropdown-hoverable' : '' }}>
  <button class="dropdown__trigger {{ $font ?? "f-secondary" }}">{{ $prompt ?? 'Select' }}<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
  <ul class="dropdown__list {{ $font ?? "f-secondary" }}" data-dropdown-list>
    @foreach ($options as $option)
      <li{!! (isset($option['active'])) ? ' class="s-active"' : '' !!}><a href="{{ $option['href'] ?? '#' }}">{!! $option['label'] ?? '' !!}</a></li>
    @endforeach
  </ul>
</span>
