<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlayerRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;


    public $player_name,$password,$subject,$created_by;

    /**
     * Create a new message instance.
     */
    public function __construct($subject,$name,$password,$created_by)
    {
        $this->subject = $subject;
        $this->name = $name;
        $this->password = $password;
        $this->created_by = $created_by;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.player-registration-maile',
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
