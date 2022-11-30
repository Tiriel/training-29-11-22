<?php

namespace App\Controller;

use App\Entity\Movie;
use App\OmdbApi\Consumer\OmdbApiConsumer;
use App\OmdbApi\Transformer\GenreTransformer;
use App\OmdbApi\Transformer\MovieTransformer;
use App\Repository\MovieRepository;
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
        $manager->getUnitOfWork()->markReadOnly($movie);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/omdb/{title}', name: 'omdb', methods: ['GET'])]
    public function omdb(string $title, OmdbApiConsumer $consumer, MovieTransformer $movieTransformer, GenreTransformer $genreTransformer): Response
    {
        $data = $consumer->fetch(OmdbApiConsumer::MODE_TITLE, $title);
        $movie = $movieTransformer->transform($data);
        foreach (explode(', ', $data['Genre']) as $genre) {
            $movie->addGenre($genreTransformer->transform($genre));
        }

        return $this->render('movie/details.html.twig', [
            'movie' => $movie
        ]);
    }
}
