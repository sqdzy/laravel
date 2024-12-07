<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use App\Models\Comment;
use Illuminate\Queue\SerializesModels;

class NewCommentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public function __construct(protected Comment $comment, protected $article_name){}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // from: new Address('moosbeere_O@mail.ru', 'Olga'),
            from: env('MAIL_FROM_ADDRESS'),
            subject: 'New Comment Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.comment.snipped',
            with: [
                'text_comment'=>$this->comment->desc,
                'article_name'=>$this->article_name,
                'url'=>'http://127.0.0.1:3000/comment/'.$this->comment->id.'/accept',
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(public_path().'/preview.jpg')
        ];
    }
}
