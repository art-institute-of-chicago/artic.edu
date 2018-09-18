<nav class="m-links-bar" data-behavior="linksBar">
    <ul class="m-links-bar__items-primary"{!! isset($ariaLabel) ? ' aria-labelledby="'.$ariaLabel.'"': '' !!} data-links-bar-primary>
        @foreach ($tags as $category => $items)
            @foreach ($items as $id => $name)

                {{-- Print the link as active only if it's the first link on the first category --}}
                {{-- and there's no filter selected. Otherwise check the actual parameters --}}

                @php
                    $active = collect(request()->input())->filter(function($value, $key) {
                        return str_contains($key, 'ef-');
                    })->isEmpty();
                @endphp

                @if ($loop->parent->first && $loop->first && $active)
                    <li class="m-links-bar__item s-active">
                @else
                    <li class="m-links-bar__item {{ (request()->input("ef-{$category}_ids") == $id) ? 's-active' : '' }} ">
                @endif
                    <button class="m-links-bar__item-trigger f-link" data-href="{!! currentUrlWithQuery(["ef-{$category}_ids" => $id]) !!}" data-ajax-tab-target="exploreFurther"{!! isset($ariaControls) ? ' aria-controls="'.$ariaControls.'"' : ''!!} aria-pressed="{{ (request()->input("ef-{$category}_ids") == $id) ? 'true' : 'false' }}">
                        {{ ucfirst($name) }}
                    </button>
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
                            <button data-href="{!! currentUrlWithQuery(["ef-{$category}_ids" => $id]) !!}" data-ajax-tab-target="exploreFurther">
                                {{ ucfirst($name) }}
                            </button>
                        </li>
                    @endforeach
                @endforeach
            </ul>
          </div>
        </li>
    </ul>
</nav>
