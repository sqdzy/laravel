<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewCommentMail;
use App\Models\Comment;

class VeryLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Comment $comment, protected $article_name)
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to('artemkov.a@mail.ru')->send(new NewCommentMail($this->comment, $this->article_name));
    }
}
