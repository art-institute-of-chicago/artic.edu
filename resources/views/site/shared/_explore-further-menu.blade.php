<nav class="m-links-bar">
    <ul class="m-links-bar__items-primary" data-links-bar-primary>
        @foreach ($tags as $category => $items)
            @foreach ($items as $id => $name)

                {{-- Print the link as active only if it's the first link on the first category --}}
                {{-- and there's no filter selected. Otherwise check the actual parameters --}}
                @if (empty(request()->input()) && $loop->parent->first && $loop->first)
                    <li class="m-links-bar__item s-active">
                @else
                    <li class="m-links-bar__item {{ (request()->input("exFurther-{$category}") == $id) ? 's-active' : '' }} ">
                @endif
                    <a class="m-links-bar__item-trigger f-link" href="{!! currentUrlWithQuery(["exFurther-{$category}" => $id]) !!}" data-ajax-tab-target="exploreFurther">
                        {{ ucfirst($name) }}
                    </a>
                </li>
            @endforeach
        @endforeach
    </ul>
</nav>
