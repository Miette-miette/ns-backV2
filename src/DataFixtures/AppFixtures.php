<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\News;
use App\Entity\Partner;
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

        $manager->flush();
    }
}
