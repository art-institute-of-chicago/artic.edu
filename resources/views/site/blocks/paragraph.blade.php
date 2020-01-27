@php
    global $_collectedReferences;
    if (!isset($_collectedReferences)) {
        $_collectedReferences = [];
    }
    list($content, $_collectedReferences)  = convertReferenceLinks($block->present()->input('paragraph'), $_collectedReferences);

    global $_paragraphCount;

    if (isset($_paragraphCount)) {
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

            $refText = $dom->createTextNode($_paragraphCount);
            $refAnchor->appendChild($refText);
            $refSpan->appendChild($refAnchor);

            foreach ($node->childNodes as $childNode) {
                $textSpan->appendChild(clone $childNode);
            }

            $newNode->appendChild($refSpan);
            $newNode->appendChild($textSpan);

            $node->parentNode->replaceChild($newNode, $node);
        }

        $content = $dom->saveHTML($dom->documentElement);
    }
@endphp
{!! $content !!}
