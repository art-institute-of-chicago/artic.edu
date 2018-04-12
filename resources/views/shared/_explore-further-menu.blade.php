<nav class="m-links-bar" data-behavior="">
    <ul class="m-links-bar__items-primary" data-links-bar-primary="">
        <li class="m-links-bar__item {{ (request()->input('exploreFurtherTagId') == null) ? 's-active' : '' }} ">
            <a class="m-links-bar__item-trigger f-buttons" href="{!! request()->url() !!}">
                All classifications
            </a>
        </li>
        @foreach ($tags as $id => $name)
            <li class="m-links-bar__item {{ (request()->input('exploreFurtherTagId') == $id) ? 's-active' : '' }} ">
                <a class="m-links-bar__item-trigger f-buttons" href="{!! request()->fullUrlWithQuery(['exploreFurtherTagId' => $id]) !!}">
                    {{ ucfirst($name) }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
