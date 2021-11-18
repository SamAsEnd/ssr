@component('mail::message')
# You are almost there

{{ $website->description }}

@component('mail::button', ['url' => $url])
Confirm Subscription
@endcomponent

@component('mail::subcopy')
To unsubscribe [click here]({{ $unsubscribeUrl }})
@endcomponent

Thanks,<br>
{{ $website->name }}
@endcomponent
