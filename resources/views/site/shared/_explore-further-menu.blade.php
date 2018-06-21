<nav class="m-links-bar" data-behavior="linksBar">
    <ul class="m-links-bar__items-primary" data-links-bar-primary>
        @foreach ($tags as $category => $items)
            @foreach ($items as $id => $name)

                {{-- Print the link as active only if it's the first link on the first category --}}
                {{-- and there's no filter selected. Otherwise check the actual parameters --}}
                @if (empty(request()->input()) && $loop->parent->first && $loop->first)
                    <li class="m-links-bar__item s-active">
                @else
                    <li class="m-links-bar__item {{ (request()->input("ef-{$category}_ids") == $id) ? 's-active' : '' }} ">
                @endif
                    <a class="m-links-bar__item-trigger f-link" href="{!! currentUrlWithQuery(["ef-{$category}_ids" => $id]) !!}" data-ajax-tab-target="exploreFurther">
                        {{ ucfirst($name) }}
                    </a>
                </li>
            @endforeach
        @endforeach

        <li class="m-links-bar__item m-links-bar__item--push m-links-bar__item--overflow" data-links-bar-primary-overflow="">
          <span aria-label="More links" class="dropdown dropdown--filter dropdown--tabs f-link" data-behavior="dropdown" tabindex="0">
            <button class="dropdown__trigger  f-link">More<svg class="icon--arrow"><use xlink:href="#icon--arrow"></use></svg></button>
            <ul class="dropdown__list f-secondary" data-dropdown-list>
                @foreach ($tags as $category => $items)
                    @foreach ($items as $id => $name)
                        @if (empty(request()->input()) && $loop->parent->first && $loop->first)
                            <li class="s-active">
                        @else
                            <li class="{{ (request()->input("ef-{$category}_ids") == $id) ? 's-active' : '' }} ">
                        @endif
                            <a href="{!! currentUrlWithQuery(["ef-{$category}_ids" => $id]) !!}" data-ajax-tab-target="exploreFurther">
                                {{ ucfirst($name) }}
                            </a>
                        </li>
                    @endforeach
                @endforeach
            </ul>
          </span>
        </li>
    </ul>
</nav>
