<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie', name: 'app_movie_')]
class MovieController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(EntityFinderInterface $finder): Response
    {
        $movie = $finder->find(Movie::class, 1);
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'Movie Index',
        ]);
    }

    #[Route('/{!id<\d+>?1}', name: 'details')]
    public function details(int $id, EntityManagerInterface $manager): Response
    {
        $movie = $manager->find(Movie::class, $id);
        $manager->getUnitOfWork()->markReadOnly($movie);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }
}
