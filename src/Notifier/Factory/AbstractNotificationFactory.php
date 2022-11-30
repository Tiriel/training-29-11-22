<?php

namespace App\Notifier\Factory;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Notifier\Notification\Notification;

class AbstractNotificationFactory implements NotificationFactoryInterface
{
    /**
     * @var IterableFactoryInterface[]
     */
    private iterable $factories;

    public function __construct(
        #[TaggedIterator('app.notification_factory')]
        iterable $factories
    ) {
        $this->factories = $factories instanceof \Traversable ? iterator_to_array($factories) : $factories;
    }

    public function createNotification(string $message, string $channel = 'email'): Notification
    {
        /** @var NotificationFactoryInterface $factory */

        return $this->factories[$channel]->createNotification($message);
    }
}