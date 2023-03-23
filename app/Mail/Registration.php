<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class Registration extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $phone;
    public $lname;
    public $fname;
    /**
     * Create a new message instance.
     */
    public function __construct($email,$phone,$lname,$fname)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->lname = $lname;
        $this->fname = $fname;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration',
            from: new Address($this->email, 'chatbot')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.users',
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
    public function build()
    {

        return $this->subject('New chatbot enquiry')
            ->markdown('emails.users');
    }
}
