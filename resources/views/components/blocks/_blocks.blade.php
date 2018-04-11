@if ($blocks)
    @foreach ($blocks as $block)
        @if (isset($block['type']))

            @if ($block['type'] === 'text')
                @php
                    $font = null;
                    $tag = null;
                    if (isset($block['subtype'])) {
                        switch ($block['subtype']) {
                            case 'intro':
                                $font = 'f-deck';
                                break;
                            case 'secondary':
                                $font = 'f-secondary';
                                break;
                            case 'heading-1':
                                $font = 'f-module-title-2';
                                $tag = 'h4';
                                break;
                            case 'heading-2':
                                $font = 'f-subheading-1';
                                $tag = 'h4';
                                break;
                        }
                    }
                    if ($font && !$tag) {
                        $block['content'] = preg_replace('/<p>/im', '<p class="'.$font.'">', $block['content']);
                    }
                    if ($font && $tag) {
                        $block['content'] = preg_replace('/<p>/im', '<'.$tag.' class="'.$font.'">', $block['content']);
                        $block['content'] = preg_replace('/<\/p>/im', '</'.$tag.'>', $block['content']);
                    }
                @endphp
                {!! $block['content'] !!}
            @endif

            @if ($block['type'] === 'intro')
                @component('components.blocks._text')
                    @slot('font', 'f-deck')
                    {!! $block['content'] !!}
                @endcomponent
            @endif

            @if ($block['type'] === 'quote')
                @component('components.atoms._quote')
                    @slot('variation', (isset($editorial) and $editorial) ? 'quote--editorial o-blocks__block' : 'o-blocks__block')
                    @slot('font', (isset($editorial) and $editorial) ? 'f-deck' : null)
                    {{ $block['content'] }}
                @endcomponent
            @endif

            @if ($block['type'] === 'hr')
                @component('components.atoms._hr')
                @endcomponent
            @endif

            @if ($block['type'] === 'accordion')
                @component('components.organisms._o-accordion')
                    @slot('variation', 'o-blocks__block '.($block['variation'] ?? ''))
                    @slot('titleFont', $block['titleFont'] ?? null)
                    @slot('items', $block['content'])
                    @slot('loopIndex', $loop->iteration)
                @endcomponent
            @endif

            @if ($block['type'] === 'media')
                @component('components.molecules._m-media')
                    @slot('variation', 'o-blocks__block')
                    @slot('item', $block['content'])
                @endcomponent
            @endif

            @if ($block['type'] === 'become-a-member')
                @component('components.molecules._m-cta-banner----become-a-member')
                    @slot('variation', 'o-blocks__block')
                @endcomponent
            @endif

            @if ($block['type'] === 'newsletter-sign-up')
                @if (isset($block['subtype']) and $block['subtype'] === 'inline')
                    @component('components.molecules._m-inline-aside')
                        @component('components.molecules._m-aside-newsletter')
                            @slot('variation','m-aside-newsletter--inline o-blocks__block')
                            @slot('placeholder','Email Address')
                        @endcomponent
                    @endcomponent
                @else
                    @component('components.molecules._m-aside-newsletter')
                        @slot('variation', (isset($block['subtype']) && $block['subtype'] ? 'm-aside-newsletter--'.$block['subtype'].' o-blocks__block' : 'o-blocks__block'))
                    @endcomponent
                @endif
            @endif

            @if ($block['type'] === 'time-line')
                @component('components.organisms._o-row-listing')
                    @slot('variation', 'o-blocks__block')
                    @foreach ($block['items'] as $item)
                        @component('components.molecules._m-listing----timeline')
                            @slot('item', $item)
                            @slot('imageSettings', array(
                                'srcset' => array(300,600,800,1200,1600),
                                'sizes' => aic_imageSizes(array(
                                      'xsmall' => '58',
                                      'small' => '58',
                                      'medium' => '38',
                                      'large' => '28',
                                      'xlarge' => '28',
                                )),
                            ))
                        @endcomponent
                    @endforeach
                @endcomponent
            @endif

            @if ($block['type'] === 'listing')
                @if (isset($block['subtype']) and $block['subtype'])
                    @if ($block["subtype"] === 'product')
                        @component('components.atoms._hr')
                        @endcomponent
                        @component('components.blocks._text')
                            @slot('font', 'f-module-title-1')
                            @slot('tag', 'h4')
                            {{ 'Featured '.str_plural(ucfirst($block['subtype']), sizeof($block['items'])) }}
                        @endcomponent
                    @endif
                    @component('components.organisms._o-row-listing')
                        @slot('variation', 'o-blocks__block')
                        @foreach ($block['items'] as $item)
                            @component('components.molecules._m-listing----'.$block["subtype"].'-row')
                                @slot('variation', 'm-listing--inline'.(($block["subtype"] === 'product') ? ' m-listing--inline-feature' : ''))
                                @slot('item', $item)
                                @if ($block["subtype"] === 'media' or $block["subtype"] === 'event')
                                    @slot('titleFont','f-list-2')
                                @endif
                                @if ($block["subtype"] === 'product')
                                    @slot('titleFont','f-list-3')
                                    @slot('imageSettings', array(
                                        'fit' => 'clamp',
                                        'ratio' => '3:4',
                                        'srcset' => array(200,400,600),
                                        'sizes' => aic_imageSizes(array(
                                              'xsmall' => '28',
                                              'small' => '12',
                                              'medium' => '9',
                                              'large' => '9',
                                              'xlarge' => '9',
                                        )),
                                    ))
                                @else
                                    @slot('imageSettings', array(
                                        'fit' => 'crop',
                                        'ratio' => '16:9',
                                        'srcset' => array(200,400,600),
                                        'sizes' => aic_imageSizes(array(
                                              'xsmall' => '58',
                                              'small' => '13',
                                              'medium' => '13',
                                              'large' => '13',
                                              'xlarge' => '13',
                                        )),
                                    ))
                                @endif
                            @endcomponent
                        @endforeach
                    @endcomponent
                @endif
            @endif

            @if ($block['type'] === 'aside')
                @if (isset($block['subtype']) and $block['subtype'])
                    @component('components.blocks._inline-aside')
                        @slot('variation', 'o-blocks__block')
                        @slot('type', $block['subtype'])
                        @slot('items', $block['items'])
                        @slot('itemsMolecule', '_m-listing----'.$block['subtype'].'-row')
                        @slot('itemsVariation', 'm-listing--inline'.(($block["subtype"] === 'product') ? ' m-listing--inline-feature' : ''))
                        @if ($block["subtype"] === 'media' or $block["subtype"] === 'event')
                            @slot('titleFont','f-list-2')
                        @endif
                        @slot('hideShortDesc', true)
                        @if ($block["subtype"] === 'product')
                            @slot('imageSettings', array(
                                'fit' => 'clamp',
                                'ratio' => '3:4',
                                'srcset' => array(200,400,600),
                                'sizes' => aic_imageSizes(array(
                                      'xsmall' => '28',
                                      'small' => '12',
                                      'medium' => '9',
                                      'large' => '9',
                                      'xlarge' => '9',
                                )),
                            ))
                        @else
                            @slot('imageSettings', array(
                                'fit' => 'crop',
                                'ratio' => '16:9',
                                'srcset' => array(200,400,600),
                                'sizes' => aic_imageSizes(array(
                                      'xsmall' => '18',
                                      'small' => '23',
                                      'medium' => '13',
                                      'large' => '8',
                                      'xlarge' => '8',
                                )),
                            ))
                        @endif
                    @endcomponent
                @endif
            @endif

            @if ($block['type'] === 'inline-listing')
                @if (isset($block['subtype']) and $block['subtype'])
                    @component('components.organisms._o-row-listing')
                        @slot('variation', 'o-blocks__block')
                        @foreach ($block['items'] as $item)
                            @component('components.molecules._m-listing----'.$block["subtype"])
                                @slot('item', $item)
                                @slot('imageSettings', array(
                                    'fit' => 'crop',
                                    'ratio' => '16:9',
                                    'srcset' => array(200,400,600,1000,1500),
                                    'sizes' => aic_imageSizes(array(
                                          'xsmall' => '58',
                                          'small' => '58',
                                          'medium' => '38',
                                          'large' => '28',
                                          'xlarge' => '28',
                                    )),
                                ))
                            @endcomponent
                        @endforeach
                    @endcomponent
                @endif
            @endif

            @if ($block['type'] === 'inline-grid')
                @if (isset($block['subtype']) and $block['subtype'])
                    @component('components.organisms._o-grid-listing')
                        @slot('variation', 'o-blocks__block  o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
                        @slot('cols_small','2')
                        @slot('cols_medium','2')
                        @slot('cols_large','2')
                        @slot('cols_xlarge','2')
                        @foreach ($block['items'] as $item)
                            @component('components.molecules._m-listing----'.$block["subtype"])
                                @slot('item', $item)
                                @slot('imageSettings', array(
                                    'fit' => 'crop',
                                    'ratio' => '16:9',
                                    'srcset' => array(200,400,600),
                                    'sizes' => aic_imageSizes(array(
                                          'xsmall' => '28',
                                          'small' => '28',
                                          'medium' => '18',
                                          'large' => '13',
                                          'xlarge' => '13',
                                    )),
                                ))
                            @endcomponent
                        @endforeach
                    @endcomponent
                @endif
            @endif

            @if ($block['type'] === 'link-list')
                @component('components.molecules._m-link-list')
                    @slot('variation', 'o-blocks__block')
                    @slot('links', $block['links']);
                @endcomponent
            @endif

            @if ($block['type'] === 'gallery')
                @if (isset($block['subtype']) and $block['subtype'])
                    @component('components.organisms._o-gallery----'.$block["subtype"])
                        @slot('variation', 'o-blocks__block')
                        @slot('title', $block['title'] ?? null);
                        @slot('caption', $block['caption'] ?? null);
                        @slot('allLink', $block['allLink'] ?? null);
                        @slot('items', $block['items']);
                            @if ($block["subtype"] === 'mosaic')
                                @slot('imageSettings', array(
                                    'srcset' => array(200,400,600,1000,1500,3000,4500),
                                    'sizes' => aic_imageSizes(array(
                                          'xsmall' => '58',
                                          'small' => '28',
                                          'medium' => '28',
                                          'large' => '28',
                                          'xlarge' => '21',
                                    )),
                                ))
                            @endif
                            @if ($block["subtype"] === 'slider')
                                @slot('imageSettings', array(
                                    'srcset' => array(200,400,600,1000,1500,3000,4500),
                                    'sizes' => aic_imageSizes(array(
                                          'xsmall' => '50',
                                          'small' => '35',
                                          'medium' => '23',
                                          'large' => '23',
                                          'xlarge' => '18',
                                    )),
                                ))
                            @endif
                    @endcomponent
                @endif
            @endif

            @if ($block['type'] === 'references')
                <ol class="list f-secondary">
                @foreach ($block['items'] as $item)
                    <li id="ref_note-{{ $item['id'] }}">{{ $item['reference'] }} <a class="return-link" href="#ref_cite-{{ $item['id'] }}"><svg class="icon--return" aria-label="back to reference"><use xlink:href="#icon--return"></use></svg></a></li>
                @endforeach
                </ol>
            @endif

            @if ($block['type'] === 'embed')
                @slot('variation', 'o-blocks__block')
                {!! $block['content'] !!}
            @endif

            @if ($block['type'] === 'deflist')
                <dl class="deflist o-blocks__block {{ $block['variation'] ?? ''}}">
                @foreach ($block['items'] as $item)
                    <div class="deflist__row">
                    <dt class="f-module-title-1">{{ $item['key'] }}</dt>
                        <dd class="f-secondary">{{ $item['value'] }}</dd>
                    </div>
                @endforeach
                </dl>
            @endif

            @if ($block['type'] === 'info-bar')
                @component('components.molecules._m-info-bar')
                    @slot('variation', 'o-blocks__block '.($block['variation'] ?? ''))
                    @slot('blocks', $block['blocks'] ?? null)
                    @slot('icon', $block['icon'] ?? null)
                @endcomponent
            @endif

            @if ($block['type'] === 'form')
                @component('components.organisms._o-form')
                    @slot('variation', 'o-blocks__block '.($block['variation'] ?? ''))
                    @slot('blocks', $block['blocks'] ?? null)
                    @slot('actions', $block['actions'] ?? null)
                @endcomponent
            @endif

            @if ($block['type'] === 'fieldset')
                @component('components.molecules._m-fieldset')
                    @slot('variation', $block['variation'] ?? null)
                    @slot('fields', $block['fields'] ?? null)
                    @slot('legend', $block['legend'] ?? null)
                @endcomponent
            @endif

            @if ($block['type'] === 'label')
                @component('components.atoms._label')
                  @slot('optional', $block['$optional'] ?? null)
                  @slot('hint', $block['$hint'] ?? null)
                  {!! $block['label'] !!}
                @endcomponent
            @endif

            @if ($block['type'] === 'input')
                @component('components.atoms._input')
                    @slot('variation', $block['variation'] ?? null)
                    @slot('id', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('name', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('placeholder', $block['placeholder'] ?? null)
                    @slot('textCount', $block['textCount'] ?? false)
                    @slot('value', $block['value'] ?? null)
                    @slot('error', $block['error'] ?? null)
                    @slot('optional', $block['optional'] ?? null)
                    @slot('hint', $block['hint'] ?? null)
                    @slot('disabled', $block['disabled'] ?? false)
                    {!! $block['label'] !!}
                @endcomponent
            @endif

            @if ($block['type'] === 'textarea')
                @component('components.atoms._textarea')
                    @slot('variation', $block['variation'] ?? null)
                    @slot('id', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('name', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('placeholder', $block['placeholder'] ?? null)
                    @slot('value', $block['value'] ?? null)
                    @slot('error', $block['error'] ?? null)
                    @slot('optional', $block['optional'] ?? null)
                    @slot('hint', $block['hint'] ?? null)
                    @slot('disabled', $block['disabled'] ?? false)
                    {!! $block['label'] !!}
                @endcomponent
            @endif

            @if ($block['type'] === 'select')
                @component('components.atoms._select')
                    @slot('variation', $block['variation'] ?? null)
                    @slot('id', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('name', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('options', $block['options'] ?? null)
                    @slot('error', $block['error'] ?? null)
                    @slot('optional', $block['optional'] ?? null)
                    @slot('hint', $block['hint'] ?? null)
                    @slot('disabled', $block['disabled'] ?? false)
                    {!! $block['label'] !!}
                @endcomponent
            @endif

            @if ($block['type'] === 'checkbox')
                @component('components.atoms._checkbox')
                    @slot('variation', $block['variation'] ?? null)
                    @slot('id', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('name', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('error', $block['error'] ?? null)
                    @slot('optional', $block['optional'] ?? null)
                    @slot('hint', $block['hint'] ?? null)
                    @slot('disabled', $block['disabled'] ?? false)
                    @slot('label', $block['label'] ?? false)
                    @slot('checked', $block['checked'] ?? false)
                @endcomponent
            @endif

            @if ($block['type'] === 'radio')
                @component('components.atoms._radio')
                    @slot('variation', $block['variation'] ?? null)
                    @slot('id', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('name', $block['name'] ?? 'i_'.$loop->iteration)
                    @slot('error', $block['error'] ?? null)
                    @slot('optional', $block['optional'] ?? null)
                    @slot('hint', $block['hint'] ?? null)
                    @slot('disabled', $block['disabled'] ?? false)
                    @slot('label', $block['label'] ?? false)
                    @slot('checked', $block['checked'] ?? false)
                @endcomponent
            @endif

            @if ($block['type'] === 'date-select')
                @component('components.atoms._date-select-input')
                    @slot('variation', $block['variation'] ?? null)
                    @slot('id', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('name', $block['id'] ?? 'i_'.$loop->iteration)
                    @slot('placeholder', $block['placeholder'] ?? null)
                    @slot('textCount', $block['textCount'] ?? false)
                    @slot('value', $block['value'] ?? null)
                    @slot('error', $block['error'] ?? null)
                    @slot('optional', $block['optional'] ?? null)
                    @slot('hint', $block['hint'] ?? null)
                    @slot('disabled', $block['disabled'] ?? false)
                    {!! $block['label'] !!}
                @endcomponent
            @endif

            @if ($block['type'] === 'artwork')
                @php
                    $artworkItem = array();
                    $artworkItem['type'] = 'image';
                    $artworkItem['media'] = $block['item']->imageFront();
                    $artworkItem['captionTitle'] = $block['item']->title;
                    $artworkItem['caption'] = $block['item']->artist.', '.$block['item']->year.' <br>'.$block['item']->galleryLocation;
                    $artworkItem['hideShare'] = true;
                    $artworkItem['fullscreen'] = true;
                @endphp
                @component('components.molecules._m-media')
                    @slot('variation', 'o-blocks__block')
                    @slot('item', $artworkItem)
                @endcomponent
            @endif


            {{-- DEAD BLOCKS
            @php
                $font = (isset($editorial) and $editorial) ? 'f-body-editorial' : false;
                $variation = false;
                $tag = false;
                //
                if (isset($block['subtype'])) {
                    switch ($block['subtype']) {
                        case 'intro':
                            $font = 'f-deck';
                            break;
                        case 'secondary':
                            $font = 'f-secondary';
                            break;
                        case 'heading-1':
                            $font = 'f-module-title-2';
                            $tag = 'h4';
                            break;
                        case 'heading-2':
                            $font = 'f-subheading-1';
                            $tag = 'h4';
                            break;
                    }
                }
                $content = $block['content'];
            @endphp
            @component('components.blocks._text')
                @slot('tag', ($tag ? $tag : null))
                @slot('variation', ($variation ? $variation : null))
                @slot('font', ($font ? $font : null))
                @slot('loopIndex', $loop->iteration)

                @if (isset($editorial) and $editorial and $loop->first and !$loop->parent and isset($dropCapFirstPara) and $dropCapFirstPara)
                    @component('components.blocks._text')
                        @slot('font','f-dropcap-editorial')
                        @slot('tag','span')
                        @php echo substr($content, 0, 1) @endphp
                    @endcomponent
                    @php echo substr($content, 1) @endphp
                @else
                    {!! $content !!}
                @endif
            @endcomponent

            @if ($block['type'] === 'unorderedList')
                <ul class="list {{ ((isset($editorial) and $editorial) ? 'f-body-editorial' : 'f-body') }}">
                @foreach ($block['items'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
                </ul>
            @endif

            @if ($block['type'] === 'orderedList')
                <ol class="list {{ ((isset($editorial) and $editorial) ? 'f-body-editorial' : 'f-body') }}">
                @foreach ($block['items'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
                </ol>
            @endif
            --}}

        @else
            @php
                var_dump($block);
            @endphp
        @endif
    @endforeach
@endif
