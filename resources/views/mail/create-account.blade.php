@component('mail::message')

    # Thank you!

    Have a newly created account.

    @component('mail::table')

        |Email            |Name               |Status           |Date         |
        |-----------------|-------------------|-----------------|-------------|
        |{{$user->email}} |{{$user->name}}    |{{empty($user->email_verified_at) ? 'Inactive' : 'Active'}}|{{$user->created_at}}|

    @endcomponent

    @component('mail::button', ['url' => 'hhttp://localhost:8089/admin/user', 'color' => 'yellow'])
        Track you shipping
    @endcomponent

    Regards,
    {{ config('app.name') }}

@endcomponent




