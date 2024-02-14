<div class="o-landingpage__prefooter o-blocks rlc">
    <div class="f-contact m-prefooter-section">
        <div class="m-prefooter-section-background">
            <h3 id="contact" class="contact-header title f-module-title-2">
                {{ $item->labels->get('contact_header') }}
            </h3>
            <div class="contact-intro">
                {!! $item->labels->get('contact_intro') !!}
            </div>
            <div class="f-contact-blocks">
                {!! $item->renderNamedBlocks('contact', data: ['hasWrapper' => true]) !!}
            </div>
        </div>
    </div>
    <div class="f-faqs m-prefooter-section">
        <div class="m-prefooter-section-background">
            <h3 id="faqs" class="faq-header title f-module-title-2">FAQs</h3>
            <div class="o-accordion" data-behavior="accordion">
                @foreach ($item->faqs as $faq)
                <h3>
                    <button
                        id="{{ StringHelpers::getUtf8Slug($faq->question) }}"
                        class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}"
                        tabindex="0"{!! (isset($item['gtmAttributes'])) ? ' '.$item['gtmAttributes'].'' : '' !!}
                        aria-expanded="{{ (isset($item['active']) and $item['active']) ? 'true' : 'false' }}"
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
            <div class="spacer-container">
                <div class="spacer">
                    <div class="semicircle left-hemisphere"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="f-donors m-prefooter-section">
    @if ($donorInfo = $item->renderNamedBlocks('donor_info'))
        <div class="m-prefooter-section-background">
            {!! $donorInfo !!}
        </div>
    @else
        @component('components.atoms._hr')
        @endcomponent
    @endif
    </div>
</div>
<div class="o-landingpage__prefooter o-blocks rlc">
    <div class="f-contact m-prefooter-section">
        <div class="m-prefooter-section-background">
            <h3 id="contact" class="contact-header title f-module-title-2">
                {{ $item->labels->get('contact_header') }}
            </h3>
            <div class="contact-intro">
                {!! $item->labels->get('contact_intro') !!}
            </div>
            <div class="f-contact-blocks">
                {!! $item->renderNamedBlocks('contact', data: ['hasWrapper' => true]) !!}
            </div>
        </div>
    </div>
    <div class="f-faqs m-prefooter-section">
        <div class="m-prefooter-section-background">
            <h3 id="faqs" class="faq-header title f-module-title-2">FAQs</h3>
            <div class="o-accordion" data-behavior="accordion">
                @foreach ($item->faqs as $faq)
                <h3>
                    <button
                        id="{{ StringHelpers::getUtf8Slug($faq->question) }}"
                        class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}"
                        tabindex="0"{!! (isset($item['gtmAttributes'])) ? ' '.$item['gtmAttributes'].'' : '' !!}
                        aria-expanded="{{ (isset($item['active']) and $item['active']) ? 'true' : 'false' }}"
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
            <div class="spacer-container">
                <div class="spacer">
                    <div class="semicircle left-hemisphere"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="f-donors m-prefooter-section">
    @if ($donorInfo = $item->renderNamedBlocks('donor_info'))
        <div class="m-prefooter-section-background">
            {!! $donorInfo !!}
        </div>
    @else
        @component('components.atoms._hr')
        @endcomponent
    @endif
    </div>
</div>
