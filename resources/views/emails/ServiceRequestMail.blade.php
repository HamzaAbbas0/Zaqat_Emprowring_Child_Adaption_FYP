@component('mail::message')
# Hello, {{ $body['name'] }}

<br />
<br />

### Your service request for {{ $body['service'] }} has been submitted <br />
Please keep checking the request status in your account and we will contact you shortly. <br />

Thanks,<br>
{{ config('app.name') }}
@endcomponent
