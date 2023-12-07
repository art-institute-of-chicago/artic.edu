<nav class="m-links-bar" data-behavior="linksBar">
    <ul class="m-links-bar__items-primary"{!! isset($ariaLabel) ? ' aria-labelledby="'.$ariaLabel.'"': '' !!} data-links-bar-primary>
        @foreach ($tags as $category => $items)
            @foreach ($items as $id => $name)

                {{-- Print the link as active only if it's the first link on the first category
                  -- and there's no filter selected. Otherwise check the actual parameters
                  --}}

                @php
                    $active = collect(request()->input())->filter(function($value, $key) {
                        return Str::contains($key, 'ef-');
                    })->isEmpty();
                @endphp

                <li class="m-links-bar__item">
                    <a class="m-links-bar__item-trigger f-link" data-behavior="exploreFurther" data-ajax-url-target="{!! Str::beforeLast(request()->url(), '/') !!}/exploreFurther?ef-{{$category}}_ids={{$id}}" data-ajax-id-target="{!! $id !!}" {!! isset($ariaControls) ? ' aria-controls="'.$ariaControls.'"' : ''!!} aria-pressed="{{ (request()->input("ef-{$category}_ids") == $id) ? 'true' : 'false' }}">
                        {{ ucfirst($name) }}
                    </a>
                </li>
            @endforeach
        @endforeach

        <li class="m-links-bar__item m-links-bar__item--push m-links-bar__item--overflow" data-links-bar-primary-overflow="">
          <div aria-label="More links" class="dropdown dropdown--filter dropdown--tabs f-link" data-behavior="dropdown" tabindex="0">
            <button class="dropdown__trigger  f-link">More<svg class="icon--arrow"><use xlink:href="#icon--arrow"></use></svg></button>
              <h4 class="sr-only" id="h-links-bar-more">More options</h4>
              <ul class="dropdown__list f-secondary" aria-labelledby="h-links-bar-more" data-dropdown-list>
                @foreach ($tags as $category => $items)
                    @foreach ($items as $id => $name)
                        @if (empty(request()->input()) && $loop->parent->first && $loop->first)
                            <li class="s-active">
                        @else
                            <li class="{{ (request()->input("ef-{$category}_ids") == $id) ? 's-active' : '' }} ">
                        @endif
                            <a href="{!! UrlHelpers::currentUrlWithQuery(["ef-{$category}_ids" => $id]) !!}">
                                {{ ucfirst($name) }}
                            </a>
                        </li>
                    @endforeach
                @endforeach
            </ul>
          </div>
        </li>
    </ul>
</nav>
