<?php

namespace App\Jobs;

use App\Enums\NotificationStatusEnum;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Notification $notification;

    /**
     * Create a new job instance.
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // TODO: Implementar a notificação
            $this->notification->status = NotificationStatusEnum::SUCCESS;
            $this->notification->save();
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
            $this->notification->status = NotificationStatusEnum::FAILED;
            $this->notification->save();
        }
    }
}
