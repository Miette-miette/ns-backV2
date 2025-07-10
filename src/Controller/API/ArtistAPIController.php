<?php

namespace App\Controller\API;

use App\Entity\Artist;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

final class ArtistAPIController extends AbstractController
{
    #[Route('/api/artist/{id}', name: 'app_artist_api', methods: ['GET'])]
    public function api(SerializerInterface $serializer, EntityManagerInterface $entityManager, ArtistRepository $repository, int $id): Response
    {
        $artist = $repository->find($id);

        return new JsonResponse(
            $serializer->serialize($artist, 'json',["groups" => ['api_event'], AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true] ),
            200,
            [],
            true
        );
        return $this->json($data, Response::HTTP_OK);
    }
}
