@component('mail::message')
# Please complete the registration by pressing the Verify Button.

@component('mail::button', ['url' => route('verify.email', $token)])
    Verify Button
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
