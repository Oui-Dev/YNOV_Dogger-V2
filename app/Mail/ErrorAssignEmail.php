<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ErrorAssignEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $projectName;
    public $errorMessage;

    /**
     * Create a new message instance.
     *
     * @param string|number $projectName
     * @param string $errorMessage
     * @return void
     */
    public function __construct($projectName, $errorMessage){
        $this->projectName = $projectName;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Build the message.s
     *
     * @return $this
     */
    public function build(){
        return $this->subject('You\'ve been assigned to an error !')
            ->view('emails.errorAssign')
            ->with([
                'projectName' => $this->projectName,
                'errorMessage' => $this->errorMessage,
            ]);
    }
}
