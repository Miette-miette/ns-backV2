<?php

namespace App\DataFixtures;

use App\Entity\Alert;
use App\Entity\Contact;
use App\Entity\News;
use App\Entity\Partner;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)

    {
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        //ALERTS
        $alerts = [];
        for ($i = 0; $i < 10; $i++) {
            $alert = new Alert();
            $alert->setType($this->faker->name())
                ->setMessage($this->faker->text());

            $alerts[] = $alert;
            $manager->persist($alert);
        }
        
        //CONTACT
        $contacts = [];
        for ($i = 0; $i < 10; $i++) {
            $contact = new Contact();
            $contact->setName($this->faker->name())
                ->setEmail($this->faker->email())
                ->setSubject($this->faker->text())
                ->setMessage($this->faker->text())
                ->setCreatedAt(new \DateTimeImmutable());

            $contacts[] = $contact;
            $manager->persist($contact);
        }

        //NEWS
        $news = [];
        for ($i = 0; $i < 10; $i++) {
            $new = new News();
            $new->setTitle($this->faker->name())
                ->setSummary($this->faker->text())
                ->setContent($this->faker->text())
                ->setImageName($this->faker->imageUrl($width = 640, $height = 480));

            $news[] = $new;
            $manager->persist($new);
        }

        //PARTNERS
        $partners = [];
        for ($i = 0; $i < 10; $i++) {
            $partner = new Partner();
            $partner->setName($this->faker->title())
                ->setType($this->faker->word())
                ->setContent($this->faker->text())
                ->setImageName($this->faker->imageUrl($width = 640, $height = 480));

            $partners[] = $partner;
            $manager->persist($partner);
        }

        //USERS
        $admin = new User();
        $admin->setFirstName('Administrateur de Nation-Sounds')
                ->setLastName(null)
                ->setEmail('admin@ns.com')
                ->setRoles(['ROLE_USER','ROLE_EDITOR','ROLE_ADMIN'])
                ->setPlainPassword('password')
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

        $manager->persist($admin);

        $editor = new User();
        $editor->setFirstName('Editeur')
                ->setLastName(null)
                ->setEmail('editor@ns.com')
                ->setRoles(['ROLE_USER','ROLE_EDITOR'])
                ->setPlainPassword('password')
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

        $manager->persist($editor);

        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstName($this->faker->name())
                ->setLastName(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            $hashPassword = $this->hasher->hashPassword(
                $user,
                'password'
            );
            $user->setPassword($hashPassword);
            $users[] = $user;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
