<div class="o-landingpage__prefooter o-blocks conservation-and-science">
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
</div>
