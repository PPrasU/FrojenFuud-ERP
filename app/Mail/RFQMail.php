<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RFQMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject($this->details['subject'])
                      ->view('emails.rfq') // View email yang akan digunakan
                      ->with('details', $this->details);

        // Jika ada lampiran
        if (isset($this->details['attachment'])) {
            $email->attach($this->details['attachment']->getRealPath(), [
                'as' => $this->details['attachment']->getClientOriginalName(),
                'mime' => $this->details['attachment']->getMimeType(),
            ]);
        }

        return $email;
    }
}
