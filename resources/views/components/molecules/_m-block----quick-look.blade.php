<div class="quick-look__header">
    @if (count($items) > 0)
        <div class="quick-look__layout">
            @foreach ($items as $item)
                @php
                    $isFeatured = $loop->first;
                @endphp
                {!! $loop->iteration == 2 ? '<div class="quick-look__side">' : '' !!}
                {!! $isFeatured ? '<div class="quick-look__featured">' : '' !!}
                @component('components.molecules._m-listing----stories-listing')
                    @slot('showDescription', $isFeatured)
                    @slot('isFeatured', $isFeatured)
                    @slot('item', $item)
                    @slot('fullscreen', false)
                    @slot('titleFont', $isFeatured ? 'f-list-4' : 'f-list-1')
                    @slot('hideImage', $loop->index > 0)
                    @slot('hideDescription', $loop->index > 0)
                    @slot('imageSettings', array(
                        'srcset' => array(300,600,800,1200,1600),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
                              'xsmall' => '58',
                              'small' => '58',
                              'medium' => '38',
                              'large' => '28',
                              'xlarge' => '28',
                        )),
                    ))
                @endcomponent
                {!! $isFeatured || $loop->last ? '</div>' : '' !!}
            @endforeach
        </div>
    @endif
    @if (count($listItems) > 0)
        <div class="quick-look__list-container">
            @if (isset($listTitle) && $listTitle)
                <div class="quick-look__list-title">
                    <h3>{!! $listTitle !!}</h3>
                </div>
            @endif
            <ol class="quick-look__list">
                @foreach ($listItems as $item)
                    <li>
                        <a class="m-listing__link quick-look__item-listing" href="{{ method_exists($item, 'getUrl') ? $item->getUrl() : $item->url_without_slug }}">
                            <span class="quick-look__list-count">{{ $loop->iteration }}</span>
                            <div class="quick-look__item-meta">
                                <span class="quick-look__item-type f-tag">{!! $item->type !!}</span>
                                @component('components.atoms._title')
                                    @slot('font', $titleFont ?? 'f-list-3')
                                    @slot('title', $item->present()->title)
                                    @slot('title_display', $item->present()->title_display)
                                @endcomponent
                            </div>
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
    @endif
</div>