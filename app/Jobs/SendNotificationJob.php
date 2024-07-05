<?php

namespace App\Jobs;

use App\Enums\NotificationChannelEnum;
use App\Enums\NotificationStatusEnum;
use App\Models\Notification as NotificationModel;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotificationPaid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected NotificationModel $notification;

    /**
     * Create a new job instance.
     */
    public function __construct(NotificationModel $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            switch ($this->notification->channel) {
                case NotificationChannelEnum::EMAIL:
                    Notification::route('mail', $this->notification->destination)
                        ->notify(new NotificationPaid($this->notification->message));
                    break;
                case NotificationChannelEnum::PUSH:
                    Log::info('no implemented');
                    break;
                case NotificationChannelEnum::SMS:
                    Log::info('no implemented');

                    break;
                case NotificationChannelEnum::WHATSAPP:
                    Log::info('no implemented');

                    break;
                default:
                    Log::info('not found');
                    break;
            }
            $this->notification->status = NotificationStatusEnum::SUCCESS;
            $this->notification->save();
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
            $this->notification->status = NotificationStatusEnum::FAILED;
            $this->notification->save();
        }
    }
}
