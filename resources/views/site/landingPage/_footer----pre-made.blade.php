@component('components.molecules._m-cta-banner')
    @slot('image', $tours_create_cta_module_image)
    @slot('href', $tours_create_cta_module_action_url)
    @slot('header', $tours_create_cta_module_header)
    @slot('body', $tours_create_cta_module_body)
    @slot('button_text', $tours_create_cta_module_button_text)
    @slot('gtmAttributes', 'data-gtm-event="'. $tours_create_cta_module_button_text . '" data-gtm-event-category="internal-ad-click"')
@endcomponent

@component('components.molecules._m-cta-banner')
    @slot('image', $tours_tickets_cta_module_image)
    @slot('href', $tours_tickets_cta_module_action_url)
    @slot('header', $tours_tickets_cta_module_header)
    @slot('body', $tours_tickets_cta_module_body)
    @slot('button_text', $tours_tickets_cta_module_button_text)
    @slot('gtmAttributes', 'data-gtm-event="'. $tours_tickets_cta_module_button_text . '" data-gtm-event-category="internal-ad-click"')
@endcomponent
