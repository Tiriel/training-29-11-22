<?php

namespace App;

use App\Controller\EntityFinderInterface;
use Psr\Log\LoggerInterface;

class TraceableMyService implements EntityFinderInterface
{
    public function __construct(
        private readonly MyService $service,
        private readonly LoggerInterface $logger
    ) {}

    public function find(string $class, int $id): object
    {
        $this->logger->info((sprintf("Fetching entity %s with id %d", $class, $id)));

        return $this->service->find($class, $id);
    }
}