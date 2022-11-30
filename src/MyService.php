<?php

namespace App;

use App\Controller\EntityFinderInterface;
use Doctrine\ORM\EntityManagerInterface;

final class MyService implements EntityFinderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $manager
    ) {}

    public function find(string $class, int $id): object
    {
        return $this->manager->find($class, $id);
    }
}