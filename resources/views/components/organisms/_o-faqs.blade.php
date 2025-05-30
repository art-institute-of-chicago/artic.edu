<div class="f-faqs m-prefooter-section">
    <div class="m-prefooter-section-background">
        <div class="m-prefooter-section-wrapper">
            @component('components.molecules._m-title-bar')
                @slot('id', 'faqs')
                @slot('titleFont', 'faq-header f-module-title-2')
                @if(isset($headerLinkUrl) && isset($headerLinkLabel))
                    @slot('links', [['href' => $headerLinkUrl, 'label' => $headerLinkLabel]])
                @endif
                FAQs
            @endcomponent
            <div class="o-accordion" data-behavior="accordion">
                @foreach ($faqs as $faq)
                <h3>
                    <button
                        id="{{ StringHelpers::getUtf8Slug($faq->question) }}"
                        class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}"
                        tabindex="0"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}
                        aria-expanded="{{ (isset($active) and $active) ? 'true' : 'false' }}"
                    >
                    {!! $faq->question !!}
                    <span class="o-accordion__trigger-icon">
                        <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
                        <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
                    </span>
                    </button>
                </h3>
                <div
                    id="panel_{{ StringHelpers::getUtf8Slug($faq->question) }}"
                    class="o-accordion__panel"
                    aria-labelledby="{{ StringHelpers::getUtf8Slug($faq['question']) }}"
                >
                    <div class="o-accordion__panel-content o-blocks">
                        @component('components.blocks._text')
                            @slot('font','f-body')
                            {!! SmartyPants::defaultTransform($faq->answer) !!}
                        @endcomponent
                    </div>
                </div>
                @endforeach
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
