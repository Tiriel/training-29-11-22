<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[IsGranted('ROLE_TOTO')]
#[Route('/terms-and-conditions', name: 'app_terms', methods: ['GET'])]
class GetTermsController
{
    public function __construct(private readonly Environment $twig) {}

    public function __invoke()
    {
        return $this->twig->render('terms.html.twig');
    }
}