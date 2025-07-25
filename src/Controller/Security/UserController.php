<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\EditUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/utilisateur/edition/{id}', name: 'app_user_edit', methods: ['GET','POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
        //verifier si le user est connecté
        if(!$this->getUser()){
            return $this->redirectToRoute('app_security_login');
        }
        //verifier si l'id de l'user match
        if($this->getUser()!==$user){
            return $this->redirect('http://localhost:3000/home');
        }

        $form = $this->createForm(EditUserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //Verifier si le mdp est bien valide
            if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())){
                $user = $form->getData();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Le compte à bien été modifié!'
                );
                return $this->redirectToRoute('app_dashboard_user',['id' => $user->getId()] );
            }
            else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe est incorrect'
                );
            }
        }

        return $this->render('security/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/utilisateur/edition-mdp/{id}', 'app_user_editmdp', methods:['GET','POST'])]
    public function editPassword(User $user, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher):Response
    {
        //verifier si le user est connecté
        if(!$this->getUser()){
            return $this->redirectToRoute('app_security_login');
        }
        //verifier si l'id de l'user match
        if($this->getUser()!==$user){
            return $this->redirect('http://localhost:3000/home');
        }

        $form = $this->createForm(ChangePasswordFormType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

                $user->setUpdatedAt(new \DateTimeImmutable());

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Le compte à bien été modifié!'
                );
                return $this->redirectToRoute('app_dashboard_user',['id' => $user->getId()] );
        }
        return $this->render('security/edit_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
