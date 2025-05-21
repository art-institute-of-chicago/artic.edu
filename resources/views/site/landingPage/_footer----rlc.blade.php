<div class="o-landingpage__prefooter o-blocks rlc">
    <div class="f-contact m-prefooter-section">
        <div class="m-prefooter-section-background">
            <div class="m-prefooter-section-wrapper">
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
    </div>
    @component('components.organisms._o-faqs')
        @slot('faqs', $item->faqs)
        @slot('active', $item['active'])
        @slot('gtmAttributes', $item['gtmAttributes'])

        <div class="spacer-container">
            <div class="spacer">
                <div class="semicircle left-hemisphere"></div>
            </div>
        </div>
    @endcomponent
    <div class="f-donors m-prefooter-section">
    @if ($donorInfo = $item->renderNamedBlocks('donor_info'))
        <div class="m-prefooter-section-background">
            <div class="m-prefooter-section-wrapper">
                {!! $donorInfo !!}
            </div>
        </div>
    @else
        @component('components.atoms._hr')
        @endcomponent
    @endif
    </div>
</div>
