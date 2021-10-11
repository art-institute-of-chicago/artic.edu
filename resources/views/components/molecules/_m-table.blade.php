@php
    use Symfony\Component\DomCrawler\Crawler;

    $crawler = new Crawler($tableHtml);

    $table = $crawler->filter('table:first-child')->first();
@endphp

@if ($table)
    <div class="m-table {{ empty($title) ? 'm-table--no-title' : '' }} m-table--{{ $size ?? 's' }} {{ ($allowWordWrap ?? false) ? 'm-table--word-wrap' : '' }}">
        <table>
            @if (!empty($title))
                <caption>
                    @component('components.molecules._m-title-bar')
                        @slot('id', 'admission')
                        @lang($title)
                    @endcomponent
                </caption>
            @endif
            @foreach ($crawler->filter('table:first-child > colgroup') as $colgroupElement)
                {!! $colgroupElement->ownerDocument->saveHTML($colgroupElement) !!}
            @endforeach
            <thead>
                @foreach ($crawler->filter('table:first-child > thead > tr') as $rowElement)
                    @php
                        $rowClass = $rowElement->getAttribute('class');
                    @endphp
                    <tr {!! !empty($rowClass) ? 'class="' . $rowClass . '"' : '' !!}>
                        @php
                            $rowCrawler = new Crawler(BlockHelpers::innerHTML($rowElement));
                        @endphp
                        @foreach ($rowCrawler->filter('td,th') as $i => $cellElement)
                            @php
                                $cellStyle = $cellElement->getAttribute('style');
                            @endphp
                            <th style="{!! !empty($cellStyle) ? $cellStyle : '' !!}">
                                @component('components.blocks._text')
                                    @slot('font', 'f-module-title-1')
                                    @slot('tag', 'span')
                                    {!! BlockHelpers::innerHTML($cellElement) !!}
                                @endcomponent
                            </th>
                            @php
                                unset($cellStyle);
                            @endphp
                        @endforeach
                        @php
                            unset($rowCrawler);
                        @endphp
                    </tr>
                    @php
                        unset($rowClass);
                    @endphp
                @endforeach
            </thead>
            <tbody>
                @foreach ($crawler->filter('table:first-child > tbody > tr') as $rowElement)
                    @php
                        $rowClass = $rowElement->getAttribute('class');
                    @endphp
                    <tr {!! !empty($rowClass) ? 'class="' . $rowClass . '"' : '' !!}>
                        @php
                            $rowCrawler = new Crawler(BlockHelpers::innerHTML($rowElement));
                        @endphp
                        @foreach ($rowCrawler->filter('td,th') as $i => $cellElement)
                            @php
                                $cellStyle = $cellElement->getAttribute('style');
                                $cellRowspan = $cellElement->getAttribute('rowspan');
                                $isCellHeader = $cellElement->nodeName === 'th' || ($i === 0 && ($hasSideHeader ?? false));
                            @endphp
                            <{!! $isCellHeader ? 'th' : 'td' !!} {!! !empty($cellStyle) ? 'style="' . $cellStyle . '"' : '' !!} {!! !empty($cellRowspan) ? 'rowspan="' . $cellRowspan . '"' : '' !!}>
                                @component('components.blocks._text')
                                    @slot('font', $isCellHeader ? 'f-module-title-1' : 'f-secondary')
                                    @slot('tag', 'span')
                                    {!! BlockHelpers::innerHTML($cellElement) !!}
                                @endcomponent
                            </{!! $isCellHeader ? 'th' : 'td' !!}>
                            @php
                                unset($cellStyle);
                                unset($cellRowspan);
                                unset($isCellHeader);
                            @endphp
                        @endforeach
                        @php
                            unset($rowCrawler);
                        @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (!empty($tableCaption))
            <div class="f-caption">{!! $tableCaption !!}</div>
        @endif
    </div>
@endif
