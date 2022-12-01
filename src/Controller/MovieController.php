<?php

namespace App\Controller;

use App\Entity\Movie;
use App\OmdbApi\Consumer\OmdbApiConsumer;
use App\OmdbApi\Provider\MovieProvider;
use App\Security\Voter\MovieVoter;
use Doctrine\ORM\EntityManagerInterface;
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
    public function details(int $id, EntityManagerInterface $manager): Response
    {
        $movie = $manager->find(Movie::class, $id);
        $this->denyAccessUnlessGranted(MovieVoter::VIEW, $movie, sprintf("You don't have the minimum age for a movie rated %s", $movie->getRated()));
        $manager->getUnitOfWork()->markReadOnly($movie);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/omdb/{title}', name: 'omdb', methods: ['GET'])]
    public function omdb(string $title, MovieProvider $provider): Response
    {
        $movie = $provider->getMovie(OmdbApiConsumer::MODE_TITLE, $title);
        $this->denyAccessUnlessGranted(MovieVoter::VIEW, $movie, sprintf("You don't have the minimum age for a movie rated %s", $movie->getRated()));

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }
}
