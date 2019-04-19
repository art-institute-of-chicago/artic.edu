<?=
    /* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
    '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    @foreach($meta as $key => $metaItem)
        @if($key === 'link')
            <{{ $key }}>{{ url($metaItem) }}</{{ $key }}>
        @elseif($key === 'title')
            <{{ $key }}><![CDATA[{{ $metaItem }}]]></{{ $key }}>
        @else
            <{{ $key }}>{{ $metaItem }}</{{ $key }}>
        @endif
    @endforeach
    @foreach($items as $item)
        <item>
            <id>{{ url($item->id) }}</id>
            <title><![CDATA[{{ $item->title }}]]></title>
            <link>{{ url($item->link) }}</link>
            <guid>{{ url($item->link) }}</guid>
            <dc:creator>{{ $item->author }}</dc:creator>
            <description type="html">
                <![CDATA[{!! $item->summary !!}]]>
            </description>
            <enclosure url="{{ url($item->enclosure) }}" length="{{ $item->enclosureLength }}" type="{{ $item->enclosureType }}" />
            <pubDate>{{ $item->updated->toAtomString() }}</pubDate>
        </item>
    @endforeach
</channel>
</rss>
