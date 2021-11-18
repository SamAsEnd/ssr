@component('mail::message')
# Welcome to {{ $website->name }}
## {{ $website->domain }}

@component('mail::panel')
## {{ $post->title }}

{{ $post->description }}
@endcomponent

@component('mail::subcopy')
To unsubscribe [click here]({{ $unsubscribeUrl }})
@endcomponent

Thanks,<br>
{{ $website->name }}
@endcomponent
