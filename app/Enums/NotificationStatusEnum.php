<?php

namespace App\Enums;

enum NotificationStatusEnum: string
{
    case PENDING = '1';
    case SUCCESS = '2';
    case ERROR = '3';
    case FAILED = '4';
    case CANCELED = '5';

    public function getName(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::SUCCESS => 'Success',
            self::ERROR => 'Error',
            self::FAILED => 'Failed',
            self::CANCELED => 'Canceled',
            default => 'Status não encontrado'
        };
    }

    public static function getLabel($value)
    {
        return match ($value) {
            self::PENDING => 'Pending',
            self::SUCCESS => 'Success',
            self::ERROR => 'Error',
            self::FAILED => 'Failed',
            self::CANCELED => 'Canceled',
            default => 'Status não encontrado'
        };
    }
}
