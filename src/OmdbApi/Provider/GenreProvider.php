<?php

namespace App\OmdbApi\Provider;

use App\OmdbApi\Transformer\GenreTransformer;
use App\Repository\GenreRepository;

class GenreProvider
{
    public function __construct(
        private readonly GenreRepository $genreRepository,
        private readonly GenreTransformer $genreTransformer
    ) {}

    public function getGenresFromString(string $genreNames): \Generator
    {
        foreach (explode(', ', $genreNames) as $name) {
            yield $this->genreRepository->findOneBy(['name' => $name])
                ?? $this->genreTransformer->transform($name);
        }
    }
}