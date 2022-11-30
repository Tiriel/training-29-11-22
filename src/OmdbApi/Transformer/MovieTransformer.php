<?php

namespace App\OmdbApi\Transformer;

use App\Entity\Movie;
use Symfony\Component\Form\DataTransformerInterface;

class MovieTransformer implements DataTransformerInterface
{
    public function transform(mixed $value)
    {
        if (!is_array($value)) {
            throw new \InvalidArgumentException("Invalid type. Expected array, got ".gettype($value));
        }

        $date = $value['Released'] === 'N/A' ? $value['Year'] : $value['Released'];

        return (new Movie())
            ->setTitle($value['Title'])
            ->setPoster($value['Poster'])
            ->setCountry($value['Country'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ->setPrice(500)
            ;
    }

    public function reverseTransform(mixed $value)
    {
        throw new \RuntimeException("Not implemented.");
    }
}