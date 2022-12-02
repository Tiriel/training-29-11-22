<?php

namespace App\EventSubscriber;

use App\Event\BookEvent;

class BookSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public function onBookEvent(BookEvent $event)
    {
        $book = $event->getBook();
        ///
    }

    public static function getSubscribedEvents()
    {
        return [
            BookEvent::class => 'onBookEvent'
        ];
    }
}