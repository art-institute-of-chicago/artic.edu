@php
    use Symfony\Component\DomCrawler\Crawler;

    $crawler = new Crawler($tableHtml);

    $table = $crawler->filter('table:first-child')->first();
@endphp

@if ($table)
    <div class="m-table {{ empty($title) ? 'm-table--no-title' : '' }}">
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
                        @foreach ($rowCrawler->filter('td,th') as $i => $cellElement)
                            @php
                                $cellStyle = $cellElement->getAttribute('style');
                                $isCellHeader = $cellElement->nodeName === 'th' || ($i === 0 && ($hasSideHeader ?? false));
                            @endphp
                            <{!! $isCellHeader ? 'th' : 'td' !!} {!! !empty($cellStyle) ? 'style="' . $cellStyle . '"' : '' !!}>
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
