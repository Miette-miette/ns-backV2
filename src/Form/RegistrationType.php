<?php

namespace App\Form;

use App\Entity\User;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 2,
                    'maxlength' => 50,
                ],
                'label' => 'Prénom',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('lastName', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 2,
                    'maxlength' => 50,
                ],
                'label' => 'Nom',
                'required' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]

            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 2,
                    'maxlength' => '180',
                ],
                'label' => 'Adresse email',
                'constraints' => [
                    new Assert\NotBlank(message:'Veuillez renseigner une adresse mail valide'),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ]
            ])

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe'
                ],
                'invalid_message' => 'Les mots de passe ne sont pas identiques.'
            ])

            ->add('privacy', CheckboxType::class, [
                'label' => "J'ai pris connaissance de la politique de confidentialité et j'accepte les termes.",
                'required' => true,
                'mapped' => false,
            ])

            ->add('Inscription',SubmitType::class)

            /*->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'Inscription',
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }


}
