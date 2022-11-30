<?php

namespace App\OmdbApi\Provider;

use App\Entity\Movie;
use App\OmdbApi\Consumer\OmdbApiConsumer;
use App\OmdbApi\Transformer\MovieTransformer;
use App\Repository\MovieRepository;

class MovieProvider
{
    public function __construct(
        private readonly MovieRepository $repository,
        private readonly OmdbApiConsumer $consumer,
        private readonly MovieTransformer $transformer,
        private readonly GenreProvider $genreProvider
    ) {}

    public function getMovie(string $mode, string $value): Movie
    {
        $data = $this->consumer->fetch($mode, $value);

        if (\array_key_exists('Title', $data)
            && $entity = $this->repository->findOneBy(['title' => $data['Title']])
        ) {
            return $entity;
        }

        $movie = $this->transformer->transform($data);
        foreach ($this->genreProvider->getGenresFromString($data['Genre']) as $genre) {
            $movie->addGenre($genre);
        }
        $this->repository->add($movie, true);

        return $movie;
    }
}