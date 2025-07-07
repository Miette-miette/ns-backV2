<?php

namespace App\Controller\API;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class NewsAPIController extends AbstractController
{
   #[Route('/api/news', name: 'api_news', methods: ['GET'])]
    public function api(SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $news = $entityManager->getRepository(News::class)->findAll();

        return new JsonResponse(
            $serializer->serialize($news, 'json'),
            200,
            [],
            true
        );
        return $this->json($data, Response::HTTP_OK);
    }
}