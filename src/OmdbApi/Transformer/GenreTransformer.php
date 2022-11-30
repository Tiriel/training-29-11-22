<?php

namespace App\OmdbApi\Transformer;

use App\Entity\Genre;
use Symfony\Component\Form\DataTransformerInterface;

class GenreTransformer implements DataTransformerInterface
{
    public function transform(mixed $value)
    {
        if (!\is_string($value)) {
            throw new \InvalidArgumentException("Invalid type. Expected string, got ".gettype($value));
        }

        return (new Genre())->setName($value);
    }

    public function reverseTransform(mixed $value)
    {
        throw new \RuntimeException("Not implemented.");
    }
}