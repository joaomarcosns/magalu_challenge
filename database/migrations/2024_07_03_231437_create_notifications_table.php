<?php

use App\Enums\NotificationChannelEnum;
use App\Enums\NotificationStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->dateTime('send_at');
            $table->string('destination', 100);
            $table->text('message');
            $table->enum('channel', array_column(NotificationChannelEnum::cases(), 'value'));
            $table->enum('status', array_column(NotificationStatusEnum::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
