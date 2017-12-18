<span aria-title="{{ $ariaTitle }}" class="dropdown{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="dropdown"{{ (isset($hoverable)) ? ' data-dropdown-hoverable' : '' }}>
  <button class="{{ $font ?? "f-secondary" }}">{{ $prompt ?? 'Select' }}<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
  <ul class="{{ $font ?? "f-secondary" }}">
    @foreach ($options as $option)
      <li{{ (isset($option['active'])) ? ' class="s-active"' : '' }}><a href="{{ $option['href'] ?? '#' }}">{{ $option['label'] ?? '' }}</a></li>
    @endforeach
  </ul>
</span>
