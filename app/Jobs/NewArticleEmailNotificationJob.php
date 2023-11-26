<?php

namespace App\Jobs;

use App\Mail\NewArticleNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewArticleEmailNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $articleTitle;
    protected array $adminUsersEmails = [];

    /**
     * Create a new job instance.
     */
    public function __construct(string $articleTitle, array $adminUsersEmails)
    {
        $this->queue = 'email_notification';
        $this->articleTitle = $articleTitle;
        $this->adminUsersEmails = $adminUsersEmails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailable = new NewArticleNotificationMail($this->articleTitle);
        foreach ($this->adminUsersEmails as $adminEmail) {
            Mail::to($adminEmail)->send($mailable);
        }
    }
}
