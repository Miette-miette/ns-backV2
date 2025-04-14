<?php

namespace App\Controller\API;

use App\Entity\Location;
use App\Entity\Map;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MapAPIController extends AbstractController
{
    #[Route('/api/carte', name: 'api_map', methods: ['GET'])]
    public function api(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {

        $carte = $entityManager->getRepository(Map::class)->findAll();
        $location = $entityManager->getRepository(Location::class)->findAll();

        return new JsonResponse(
            $serializer->serialize([$carte, $location], 'json'),
            200,
            [],
            true
        );
        return $this->json($data, Response::HTTP_OK);
    }  
}
