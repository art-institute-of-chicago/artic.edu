@component('mail::message')

# Event planning contact request

A contact request for event planning was been submitted on our website. Following are the details.

{{ $eventPlanningContact->toMarkdown() }}

------------------
Submitted on {{ now()->toFormattedDateString() }} at {{ now()->toTimeString() }}
@endcomponent
