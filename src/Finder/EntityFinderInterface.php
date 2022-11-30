<?php

namespace App\Finder;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'app.finder')]
interface EntityFinderInterface
{
    public function find(string $class, int $id): object;
}