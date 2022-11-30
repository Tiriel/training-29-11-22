<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_default_')]
class DefaultController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(MovieRepository $repository): Response
    {
        $movies = $repository->findBy([], ['id' => 'DESC'], 6);

        return $this->render('default/index.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'contact',
        ]);
    }
}
