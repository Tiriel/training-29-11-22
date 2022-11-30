<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\DiscordNotification;
use Symfony\Component\Notifier\Notification\Notification;

class DiscordNotificationFactory implements NotificationFactoryInterface, IterableFactoryInterface
{

    public function createNotification(string $message): Notification
    {
        return new DiscordNotification($message, ['chat/discord']);
    }

    public static function getDefaultIndexName(): string
    {
        return 'discord';
    }
}