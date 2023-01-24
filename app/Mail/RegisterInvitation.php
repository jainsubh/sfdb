<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $token)
    {
        $this->username  = $data->name;
        $this->reset_link = config('app.url').'/password/reset/'.$token.'?email='.$data->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name').' Password Reset Link')->view('admin::auth/registerationLink')->with(['name' => $this->username, 'reset_link' => $this->reset_link]);
    }
}
