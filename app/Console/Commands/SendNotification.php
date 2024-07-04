<?php

namespace App\Console\Commands;

use App\Enums\NotificationStatusEnum;
use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use Illuminate\Console\Command;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $notifications = $this->checkAndSend();

        $notifications->each(function ($notification) {
            dispatch(new SendNotificationJob(notification: $notification))->onQueue('send-notification');
        });
    }


    protected function checkAndSend()
    {
        return Notification::isPast()->whereIn("status", [NotificationStatusEnum::PENDING, NotificationStatusEnum::FAILED])->get();
    }
}
