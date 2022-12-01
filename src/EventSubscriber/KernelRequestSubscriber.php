<?php

namespace App\EventSubscriber;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class KernelRequestSubscriber implements EventSubscriberInterface
{
    private bool $isMaintenance;

    public function __construct(
        private readonly Environment $twig,
        #[Autowire('%env(bool:IS_MAINTENANCE)%')]
        bool $isMaintenance
    )
    {
        $this->isMaintenance = $isMaintenance;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->isMaintenance) {
            $event->setResponse(
                new Response($this->twig->render('maintenance.html.twig'))
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 9999],
        ];
    }
}
