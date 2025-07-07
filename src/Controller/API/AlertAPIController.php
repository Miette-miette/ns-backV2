<?php

namespace App\Controller\API;

use App\Entity\Alert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class AlertAPIController extends AbstractController
{
   #[Route('/api/alert', name: 'api_alert', methods: ['GET'])]
    public function api(SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $alert = $entityManager->getRepository(Alert::class)->findAll();

        return new JsonResponse(
            $serializer->serialize($alert, 'json'),
            200,
            [],
            true
        );
        return $this->json($data, Response::HTTP_OK);
    }
}