<?php

namespace App\Controller\Pages;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(EntityManagerInterface $entityManager,Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact;
        
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $contactData = $form->getData();
            $entityManager->persist($contactData);
            $entityManager->flush();

            //Email
            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('admin@nationsounds.com')
                ->subject($contact->getSubject())
                ->htmlTemplate('emails/contact.html.twig')
                ->context(['contact' => $contact]);

            $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre message a bien été envoyé!'
            );

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('pages/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}