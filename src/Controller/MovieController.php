<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie', name: 'app_movie_')]
class MovieController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'Movie Index',
        ]);
    }

    #[Route('/{!id<\d+>?1}', name: 'details')]
    public function details(int $id, MovieRepository $repository): Response
    {
        return $this->render('movie/details.html.twig', [
            'movie' => $repository->find($id),
        ]);
    }
}
