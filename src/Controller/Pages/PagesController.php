<?php

namespace App\Controller\Pages;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PagesController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_legal_notice')]
    public function legal_notice(): Response
    {
        return $this->render('Pages/mentions-legales.html.twig');
    }

    #[Route('/politique_confidentialite', name: 'app_privacy_policy')]
    public function privacy_policy(): Response
    {
        return $this->render('Pages/privacy-policy.html.twig');
    }
}