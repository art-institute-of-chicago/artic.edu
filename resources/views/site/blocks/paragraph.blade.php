@php
    global $_collectedReferences;
    if (!isset($_collectedReferences)) {
        $_collectedReferences = [];
    }
    list($content, $_collectedReferences)  = convertReferenceLinks($block->present()->input('paragraph'), $_collectedReferences);

    global $_paragraphCount;

    if (isset($_paragraphCount)) {
        $dom = new DomDocument();
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXpath($dom);
        $nodes = $xpath->query('//p');

        foreach($nodes as $node) {
            $_paragraphCount++;
            $node->setAttribute('id', 'p-' . $_paragraphCount);
        }

        $content = $dom->saveHTML();
    }
@endphp
{!! $content !!}
