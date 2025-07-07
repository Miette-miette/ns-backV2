<?php

namespace App\Controller\API;

use App\Entity\Partner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class PartnerAPIController extends AbstractController
{
   #[Route('/api/partner', name: 'api_partner', methods: ['GET'])]
    public function api(SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $partner = $entityManager->getRepository(Partner::class)->findAll();

        return new JsonResponse(
            $serializer->serialize($partner, 'json'),
            200,
            [],
            true
        );
        return $this->json($data, Response::HTTP_OK);
    }
}