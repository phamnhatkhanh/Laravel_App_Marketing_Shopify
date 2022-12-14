<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTestPreview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * get body Email after handle with dom
     *
     * @var object
     */
    private $bodyEmail;

    /**
     * Get subject Email after handle with dom
     *
     * @var object
     */
    private $subject;

    /**
     * Get name image
     *
     * @var object
     */
    private $imageName;

    /**
     * Get shop owner information have token
     *
     * @var array
     */
    private $store;

    /**
     * Get information receiver
     *
     * @var object
     */
    private $sendEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bodyEmail, $subject, $imageName, $store, $sendEmail)
    {
        $this->bodyEmail = $bodyEmail;
        $this->subject =$subject;
        $this->imageName = $imageName;
        $this->store = $store;
        $this->sendEmail = $sendEmail;
    }

    /**
     * Send Test mail Campaign to chosen one
     *
     * @return void
     */
    public function handle()
    {
        $bodyEmail = $this->bodyEmail;
        $subject = $this->subject;
        $store = $this->store;
        info($store);
        $sendEmail = $this->sendEmail;

        Mail::send('mail.emailPreview', compact('bodyEmail' ), function ($email) use ($subject, $store,$sendEmail) {
            $email->from($store->email);
            $email->to($sendEmail)->subject($subject);
        });
    }
}
