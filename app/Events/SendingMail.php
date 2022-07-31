<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use App\Models\JobBatch;

class SendingMail implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $batch_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($batch_id)
    {
        $this->batch_id = $batch_id;
        $this->message  = $this->sendProcess();
    }

    public function sendProcess(){
        info("sedding mail ". $this->batch_id);
        $batches =  JobBatch::find($this->batch_id);
        return 'Finish: '.$batches->finished_at.
            ' - Processing: '.$batches->progress().'%'.
            ' - Send: '. $batches->processedJobs().
            ' - Fail: '.$batches->failed_jobs;
    }


    public function broadcastOn()
    {
        return ['SendingMail'];
    }
    public function broadcastAs(){
        return 'send-processing';
    }
}