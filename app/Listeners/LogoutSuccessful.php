<?php

namespace App\Listeners;

use IlluminateAuthEventsLogout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Traits\LogsActivity;

class LogoutSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IlluminateAuthEventsLogout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $event->subject = 'logout';
        $event->description = 'Logout Successful';

        activity($event->subject)->by($event->user)->log($event->description);
    }
}
