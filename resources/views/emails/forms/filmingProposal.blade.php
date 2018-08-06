@component('mail::message')

# Filming and Photo Shoot Proposal

A proposal for a filming and photo shoot has been submitted on our website. Following are the details.

{{ $filmingProposal->toMarkdown() }}

------------------
Submitted on {{ now()->toFormattedDateString() }} at {{ now()->toTimeString() }}
@endcomponent
