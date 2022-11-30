<?php

namespace App\Controller;

interface EntityFinderInterface
{
    public function find(string $class, int $id): object;
}