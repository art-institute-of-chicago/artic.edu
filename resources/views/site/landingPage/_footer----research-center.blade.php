<div class="o-landingpage__prefooter o-blocks research-center">
    @component('components.organisms._o-faqs')
        @slot('faqs', $item->faqs)
        @slot('active', $item['active'])
        @slot('gtmAttributes', $item['gtmAttributes'])
        @slot('headerLinkUrl', $item->labels['faq_link_url'])
        @slot('headerLinkLabel', $item->labels['faq_link_label'])
    @endcomponent
</div>
