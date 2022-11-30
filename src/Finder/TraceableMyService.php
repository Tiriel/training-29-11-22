<?php

namespace App\Finder;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsDecorator(decorates: 'App\Finder\MyService')]
class TraceableMyService implements EntityFinderInterface
{
    private readonly bool $isLogged;

    public function __construct(
        private readonly MyService $service,
        private readonly LoggerInterface $logger,
        #[Autowire('%env(bool:IS_LOGGED)%')] bool $isLogged
    ) {
        $this->isLogged = $isLogged;
    }

    public function find(string $class, int $id): object
    {
        if ($this->isLogged) {
            $this->logger->info((sprintf("Fetching entity %s with id %d", $class, $id)));
        }

        return $this->service->find($class, $id);
    }
}