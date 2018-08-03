@component('mail::message')

# Filming and Photo Shoot Proposal

A request for a filming and photo shoot proposal was been submitted on our website. Following are the details.

{{ $filmingProposal->toMarkdown() }}

------------------
Submitted on {{ now()->toFormattedDateString() }} at {{ now()->toTimeString() }}
@endcomponent
