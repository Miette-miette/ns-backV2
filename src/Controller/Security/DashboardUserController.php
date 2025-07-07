<?php

namespace App\Controller\Security;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\SecurityBundle\Security;

class DashboardUserController extends AbstractController
{
    public function __construct(
        private Security $security,
    ) {
    }
    
    #[Route('/utilisateur/dashboard/{id}', name: 'app_dashboard_user')]
    public function index(#[CurrentUser()] ?User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    
        if ($user) {
            if ($this->security->isGranted('ROLE_ADMIN')){
                return $this->redirectToRoute('admin_index');
            }
            else{
                return $this->render('security/dashboard_user.html.twig', [
                    'user' => $user
                ]);
            }
            
        }
        
        else {
            throw $this->createAccessDeniedException('Utilisateur non authentifié.');
        }
    }
    
        
}
