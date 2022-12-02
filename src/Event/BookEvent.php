<?php

namespace App\Event;

use App\Entity\Book;
use Symfony\Contracts\EventDispatcher\Event;

class BookEvent extends Event
{
    public function __construct(private Book $book)
    {
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function setBook(Book $book): BookEvent
    {
        $this->book = $book;
        return $this;
    }
}