@php
    global $_collectedReferences;
    if (!isset($_collectedReferences)) {
        $_collectedReferences = [];
    }
    list($content, $_collectedReferences)  = StringHelpers::convertReferenceLinks($block->present()->input('paragraph'), $_collectedReferences);

    global $_paragraphCount;

    if (isset($_paragraphCount)) {
        $oldInternalErrors = libxml_use_internal_errors(true);

        $dom = new DomDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXpath($dom);
        $nodes = $xpath->query('//p');

        $wrapper = $dom->createElement('div');
        $wrapper->setAttribute('class','wrapper');

        foreach($nodes as $node) {
            $_paragraphCount++;

            $newNode = $dom->createElement('p');
            $newNode->setAttribute('id', 'p-' . $_paragraphCount);
            $newNode->setAttribute('class', 'p--linked');

            $refSpan = $dom->createElement('span');
            $refSpan->setAttribute('class', 'p--linked__ref');

            $textSpan = $dom->createElement('span');
            $textSpan->setAttribute('class', 'p--linked__text');

            $refAnchor = $dom->createElement('a');
            $refAnchor->setAttribute('href', '#p-' . $_paragraphCount);
            $refAnchor->setAttribute('class', 'reset');

            $refText = $dom->createTextNode($_paragraphCount);
            $refAnchor->appendChild($refText);
            $refSpan->appendChild($refAnchor);

            foreach ($node->childNodes as $childNode) {
                $textSpan->appendChild(clone $childNode);
            }

            $newNode->appendChild($textSpan);
            $newNode->appendChild($refSpan);

            $node->parentNode->replaceChild($newNode, $node);
        }

        $content = $dom->saveHTML($dom);

        libxml_clear_errors();
        libxml_use_internal_errors($oldInternalErrors);
    }

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

    $content = $dom->saveHTML($dom);

    libxml_clear_errors();
    libxml_use_internal_errors($oldInternalErrors);
@endphp
{!! $content !!}
