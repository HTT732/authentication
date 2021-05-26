<?php

namespace App\Listeners;

use App\Events\CreateAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\SendCreateAccount;
use App\Providers\EventServiceProvider;
use Mail;

class SendCreateAccountNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CreateAccount $event)
    {
        Mail::to($event->admin['email'])->send(new SendCreateAccount($event->user, $event->admin));
    }
}
