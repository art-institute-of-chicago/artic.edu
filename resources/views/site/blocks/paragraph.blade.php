@php
    $content = StringHelpers::parseFootnotes($block->present()->input('paragraph'));

    $oldInternalErrors = libxml_use_internal_errors(true);

    $dom = new DomDocument();
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    // Give IDs to H2s, H3s, and H4s
    $xpath = new DOMXpath($dom);

    foreach($xpath->query('//h2') as $node) {
        $node->setAttribute('id', Str::slug($node->nodeValue));
    }

    foreach($xpath->query('//h3') as $node) {
        $node->setAttribute('id', Str::slug($node->nodeValue));
    }

    foreach($xpath->query('//h4') as $node) {
        $node->setAttribute('id', Str::slug($node->nodeValue));
    }

    $content = str_replace('<?xml encoding="utf-8" ?>', '', $dom->saveHTML($dom));

    libxml_clear_errors();
    libxml_use_internal_errors($oldInternalErrors);
@endphp
@if (isset($hasWrapper) && $hasWrapper)
<div class="paragraph-wrapper">
    {!! $content !!}
</div>
@else
    {!! $content !!}
@endif
