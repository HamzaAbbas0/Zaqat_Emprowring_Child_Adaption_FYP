@component('mail::message')
# Dear, {{ $body['name'] }}

<br />
<br />

This message is to confirm that your {{ config('app.name') }} account password has been successfully changed. <br />

Thanks,<br>
{{ config('app.name') }}
@endcomponent
