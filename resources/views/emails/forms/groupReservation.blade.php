@component('mail::message')

# Group reservation request

A request for a group reservation has been submitted on our website. Following are the details.

{{ $groupReservation->toMarkdown() }}

------------------
Submitted on {{ now()->toFormattedDateString() }} at {{ now()->toTimeString() }}
@endcomponent
