<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class SecurityController extends AbstractController
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    #[Route('/connexion', name: 'app_login', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils, #[CurrentUser] ?User $user,Request $request): Response
    {
        // if user is already logged in, don't display the login page again
        // if editor => display the dashboard admin
        if ($user) {
            if ($user->getRoles() == 'ROLE_EDITOR'){

                $cookie = Cookie::create('user')
                    ->withValue('log')
                    ->withHttpOnly(false);

                    $response = new Response();
                    $response->headers->setCookie($cookie);

                    $response->send();

                return $this->redirectToRoute('admin_index');
            }
            else{

                $cookie = Cookie::create('user')
                ->withValue('log')
                ->withExpires(0)
                ->withHttpOnly(false);

                $response = new Response();
                $response->headers->setCookie($cookie);

                $response->send();

                return $this->redirectToRoute('app_dashboard_user', ['id' => $user->getId()]);
            }
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
             'last_username' => $lastUsername,
             'error' => $error,
        ]);
    }

    #[Route('/deconnexion', name: 'app_security_logout')]
    public function logout(): Response
    {
        $response = new Response();
        $response->headers->clearCookie('user');
        $response->send();

        return $this->redirect($this->generateUrl('http://localhost:8000/'));
    }

    #[Route('/inscription', name: 'app_registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $form = $this->createForm(RegistrationType::class, $user);
        //$errors = $form->getErrors();


        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $userData = $form->getData();
            $hashPassword = $this->hasher->hashPassword(
                $user,
                'password'
            );
            $user->setPassword($hashPassword);
            $entityManager->persist($userData);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été crée!'
            );

            return $this->redirectToRoute('app_login');
        }


        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ],);
    }
}
