<?php

namespace App\Models;

use App\Enums\NotificationChannelEnum;
use App\Enums\NotificationStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'send_at',
        'destination',
        'message',
        'channel',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'channel',
        'status',
    ];

    protected $casts = [
        'status' => NotificationStatusEnum::class,
        'channel' => NotificationChannelEnum::class
    ];

    protected $appends = [
        'status_label',
        'channel_label',
    ];

    public function getStatusLabelAttribute()
    {
        return NotificationStatusEnum::getLabel($this->status);
    }

    public function getChannelLabelAttribute()
    {
        return NotificationChannelEnum::getLabel($this->channel);
    }
}
