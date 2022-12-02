<?php

namespace App\Controller;

use App\Entity\Book;
use App\Event\BookEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Route('/book', name: 'app_book_')]
class BookController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/{id<\d+>?1}', name: 'show', methods: ['GET'])]
//    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], defaults: ['id' => 1], methods: ['GET'])]
    public function show(Book $book, EventDispatcherInterface $dispatcher): Response
    {
        $dispatcher->dispatch(new BookEvent($book));

        return $this->render('book/index.html.twig', [
            'controller_name' => $book->getId(),
        ]);
    }
}
