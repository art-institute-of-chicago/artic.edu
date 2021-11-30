@include('admin.partials.create')

@formField('checkbox', [
    'name' => 'is_affiliate_group',
    'label' => 'This program represents an affiliate group',
])


@formField('checkbox', [
    'name' => 'is_event_host',
    'label' => 'This program represents an event host',
])
