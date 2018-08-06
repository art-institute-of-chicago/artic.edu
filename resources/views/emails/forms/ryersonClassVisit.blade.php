@component('mail::message')

# Ryerson class visit request

A request for a class visit to the Ryerson was been submitted on our website. Following are the details.

{{ $ryersonClassVisit->toMarkdown() }}

------------------
Submitted on {{ now()->toFormattedDateString() }} at {{ now()->toTimeString() }}
@endcomponent
