<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Exception extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Stores exception details
     *
     * @var array
     */
    public $options;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $options) {
        $this->options = $options;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->subject($this->options['subject'])
            ->view('mail.exception');
    }
}
