@component('mail::message')
# Hello {{ $body['name'] }}

Hope you are fine, this email is to gently reminder to please upload verification email for your membership for North mason club.
<br />

Thanks,<br>
{{ config('app.name') }}
@endcomponent
