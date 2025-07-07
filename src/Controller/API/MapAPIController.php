<?php

namespace App\Controller\API;

use App\Entity\Location;
use App\Entity\Map;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class MapAPIController extends AbstractController
{
    #[Route('/api/map', name: 'api_map', methods: ['GET'])]
    public function api(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {

        $carte = $entityManager->getRepository(Map::class)->findAll();

        return new JsonResponse(
            $serializer->serialize($carte, 'json'),
            200,
            [],
            true
        );
        return $this->json($data, Response::HTTP_OK);
    } 
    
    #[Route('/api/marker', name: 'api_marker', methods: ['GET'])]
    public function apiMarker(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {

        $location = $entityManager->getRepository(Location::class)->findAll();

        return new JsonResponse(
            $serializer->serialize($location, 'json',["groups" => ['api_location'], AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]),
            200,
            [],
            true
        );
        return $this->json($data, Response::HTTP_OK);
    } 
}
