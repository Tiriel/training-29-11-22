<?php

namespace App;

interface EntityFinderInterface
{
    public function find(string $class, int $id): object;
}