<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $minutes;
    public $name;
    public $url;

    public function __construct(string $otp, int $minutes, string $name, string $url)
    {
        $this->otp = $otp;
        $this->minutes = $minutes;
        $this->name = $name;
        $this->url = $url;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('messages.mail.verification_code'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'otp' => $this->otp,
                'minutes' => $this->minutes,
                'name' => $this->name,
                'url' => $this->url,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
