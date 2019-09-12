@php
    use Symfony\Component\DomCrawler\Crawler;

    $title = $block->input('table_title');

    // Avoid $block->present() here due to ---
    $markdown = $block->input('table_markdown');
    $parser = new Parsedown();
    $html = $parser->text($markdown);

    $crawler = new Crawler($html);

    // Only get first table, ignore any other content
    $table = $crawler->filter('table:first-child')->first();
@endphp

@if ($table)
    <div class="m-table">
        <table>
            @if (!empty($title))
                <caption>
                    @component('components.molecules._m-title-bar')
                        @slot('id', 'admission')
                        @lang($title)
                    @endcomponent
                </caption>
            @endif
            <thead>
                <tr>
                    @foreach ($crawler->filter('table:first-child > thead > tr > th') as $cellElement)
                        @php
                            $cellStyle = $cellElement->getAttribute('style');
                        @endphp
                        <th style="{!! !empty($cellStyle) ? $cellStyle : '' !!}">
                            @component('components.blocks._text')
                                @slot('font', 'f-module-title-1')
                                @slot('tag', 'span')
                                {!! innerHTML($cellElement) !!}
                            @endcomponent
                        </th>
                        @php
                            unset($cellStyle);
                        @endphp
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($crawler->filter('table:first-child > tbody > tr') as $rowElement)
                    <tr>
                        @php
                            $rowCrawler = new Crawler(innerHTML($rowElement));
                        @endphp
                        @foreach ($rowCrawler->filter('td') as $i => $cellElement)
                            @php
                                $cellStyle = $cellElement->getAttribute('style');
                                $isCellHeader = $i === 0 && $block->input('has_side_header');
                            @endphp
                            <{!! $isCellHeader ? 'th' : 'td' !!} style="{!! !empty($cellStyle) ? $cellStyle : '' !!}">
                                @component('components.blocks._text')
                                    @slot('font', $isCellHeader ? 'f-module-title-1' : 'f-secondary')
                                    @slot('tag', 'span')
                                    {!! innerHTML($cellElement) !!}
                                @endcomponent
                            </{!! $isCellHeader ? 'th' : 'td' !!}>
                            @php
                                unset($cellStyle);
                            @endphp
                        @endforeach
                        @php
                            unset($rowCrawler);
                        @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
