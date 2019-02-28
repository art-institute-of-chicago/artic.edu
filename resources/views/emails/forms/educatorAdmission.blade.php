@component('mail::message')

# Educator admission request

Welcome Illinois educator! Thank you for planning a visit to the Art Institute of Chicago. Present
this voucher and your educator ID at the ticket counter to receive your general admission ticket.

Learn more about professional development [opportunities](https://www.artic.edu/learn-with-us/educators/learn-with-my-peers)
and [resources](https://www.artic.edu/learn-with-us/educators/tools-for-my-classroom/resource-finder) for K-12 educators.

{{ $educatorAdmission->toMarkdown() }}

------------------
Submitted on {{ now()->toFormattedDateString() }} at {{ now()->toTimeString() }}
@endcomponent
