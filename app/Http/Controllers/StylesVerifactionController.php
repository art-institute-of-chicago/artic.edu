<?php

namespace App\Http\Controllers;

class StylesVerifactionController extends Controller
{
    public const FONT_CLASSES = [
        // 'f-autocomplete', Not in use
        'f-body',
        'f-body-editorial',
        'f-body-editorial-emphasis',
        'f-body-editorial-reference',
        'f-body-emphasis',
        'f-buttons',
        'f-caption',
        'f-caption-title',
        'f-deck',
        'f-display-1',
        'f-display-2',
        'f-display-3',
        'f-dropcap-editorial',
        // 'f-h1', Not in use
        'f-headline',
        'f-headline-editorial',
        'f-headline-lightbox',
        'f-link',
        'f-list-1',
        'f-list-1--dense',
        'f-list-2',
        'f-list-3',
        'f-list-4',
        'f-list-5',
        'f-list-6',
        'f-list-7',
        'f-main-nav',
        'f-module-title-1',
        'f-module-title-2',
        // 'f-module-title-3', Why doesn't this exist?
        'f-module-title-4',
        'f-numeral-date',
        'f-quote',
        'f-secondary',
        'f-small-caps',
        'f-subheading-1',
        'f-subheading-2',
        'f-subheading-3',
        'f-tag',
        'f-tag-2',
        'f-tertiary',
        // 'f-ui', Not in use
    ];
    // These are font-object definitions that do not have an associated `f-*` class:
    // $f-aside-subtitle,
    // $f-audio-subtitle,
    // $f-autocomplete, Not in use
    // $f-search-input,

    public const NESTED_ELEMENTS = ['span', 'b', 'strong', 'i', 'em'];

    public function show()
    {
        return view('site.stylesVerification', [
            'classes' => self::FONT_CLASSES,
            'elements' => self::NESTED_ELEMENTS,
        ]);
    }
}
