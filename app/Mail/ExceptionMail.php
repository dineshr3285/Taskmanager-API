<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExceptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Stores exception details
     *
     * @var array
     */
    public $options = [];

    /**
     * Create a new message instance.
     *
     * @param  array $options
     *
     * @return void
     */
    public function __construct(array $options)
    {
        $this->options = $options;
        app('log')->info('job contrsuctor exception mail' . json_encode($this->options));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        app('log')->info(json_encode($this->options));

        return $this
            ->subject($this->options['subject'] ?? config('app.name') . ' ' . config('app.env') . 'error')
            ->view('mail.exception');
    }
}
