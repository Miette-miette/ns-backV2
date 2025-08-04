<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserAPIController extends AbstractController
{
    #[Route('/api/userme', name: 'api_me', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')] 
    public function me(): JsonResponse
    {
        /** @var \App\Entity\User|null $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['error' => 'Not authenticated'], 401);
        }

        try {
            return $this->json([
                'user' => [
                    'id' => $user->getId(),
                    'username' => $user->getFirstName(),
                    'email' => $user->getEmail()
                ]
            ]);
        } catch (\Throwable $e) {
            return $this->json([
                'error' => 'Erreur interne',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
