@component('mail::message')
# Good bye from {{ $website->name }}
## {{ $website->domain }}

{{ $website->farewell_message }}

Thanks,<br>
{{ $website->name }}
@endcomponent
