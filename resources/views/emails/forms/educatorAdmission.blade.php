@component('mail::message')

# Educator admission request

A request for a educator admission was been submitted on our website. Following are the details.

{{ $educatorAdmission->toMarkdown() }}

------------------
Submitted on {{ now()->toFormattedDateString() }} at {{ now()->toTimeString() }}
@endcomponent
