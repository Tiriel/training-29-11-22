<?php

namespace App\Notifier;

use App\Entity\User;
use App\Notifier\Factory\AbstractNotificationFactory;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class MovieNotifier
{
    public function __construct(
        private readonly NotifierInterface $notifier,
        private readonly AbstractNotificationFactory $factory
    ) {}

    public function notifyUser(User $user, string $message = 'Your movie droppedon our platform!'): void
    {
        $recipient = new Recipient($user->getEmail(), '0000000000');
        $notification = $this->factory->createNotification($message, $user->getPreferredChannel());

        $this->notifier->send($notification, $recipient);
    }
}