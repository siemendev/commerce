<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class StartPageController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('pages/startpage.html.twig');
    }
}
