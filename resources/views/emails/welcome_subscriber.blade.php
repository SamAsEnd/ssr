@component('mail::message')
# Welcome to {{ $website->name }}
## {{ $website->domain }}

{{ $website->onboard_message }}

@component('mail::subcopy')
To unsubscribe [click here]({{ $unsubscribeUrl }})
@endcomponent

Thanks,<br>
{{ $website->name }}
@endcomponent
