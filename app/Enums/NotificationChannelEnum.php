<?php

namespace App\Enums;

enum NotificationChannelEnum: string
{
    case EMAIL = '1';
    case PUSH = '2';
    case SMS = '3';
    case WHATSAPP = '4';

    public function getName(): string
    {
        return match ($this) {
            self::EMAIL => 'Email',
            self::PUSH => 'Push Notification',
            self::SMS => 'SMS',
            self::WHATSAPP => 'WhatsApp',
            default => 'Canal de notificação não reconhecido',
        };
    }

    public static function getLabel($value)
    {
        return match ($value) {
            self::EMAIL => 'Email',
            self::PUSH => 'Push Notification',
            self::SMS => 'SMS',
            self::WHATSAPP => 'WhatsApp',
            default => 'Canal de notificação não reconhecido',
        };
    }
}
