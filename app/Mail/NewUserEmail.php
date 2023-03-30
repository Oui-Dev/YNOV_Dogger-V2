<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     * @param string $password
     * @return void
     */
    public function __construct($user, $password){
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.s
     *
     * @return $this
     */
    public function build(){
        return $this->subject('You\'re Dogger account has been created !')
            ->view('emails.newUser')
            ->with([
                'user' => $this->user,
                'organization' => $this->user->organization,
                'password' => $this->password,
            ]);
    }
}
