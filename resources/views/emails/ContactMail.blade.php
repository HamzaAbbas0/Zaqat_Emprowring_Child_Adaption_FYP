@component('mail::message')
# You received new contact request

### Contact Details: <br />
**Name**: {{ $body['name'] }} <br />
**Email**: {{ $body['email'] }} <br />
**Subject**: {{ $body['subject'] }} <br />
**Message**: {{ $body['message'] }} <br />
<br />


### Author Account Details: <br />
**Name**: {{ $body['author']['name'] }} <br />
**Email**: {{ $body['author']['email'] }} <br />

Thanks,<br>
{{ config('app.name') }}
@endcomponent
