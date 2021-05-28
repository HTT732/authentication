@component('mail::message')
    #Hello, {{$admin['name']}}!

    Have a newly created account.
    Name  : {{$user->name}}
    Email : {{$user->email}}
    Status: {{empty($user->email_verified_at) ? 'Inactive' : 'Active'}}
    Date  : {{$user->created_at}}

    Regards,
    {{ config('app.name') }}
@endcomponent




