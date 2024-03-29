<?php

namespace App\DataFixtures;

use app\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder,
    private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('DoBleedPurple@gmail.com');
        $admin->setLastname('Dantes');
        $admin->setFirstname('Devil');
        $admin->setAddress('12 rue Sherlock Holmes');
        $admin->setZipcode('66669');
        $admin->setCity('Gomorra');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        
        $manager->persist($admin);


        $faker = Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <= 5; $usr++){

            $user = new Users();
        $user->setEmail($faker->email);
        $user->setLastname($faker->lastName);
        $user->setFirstname($faker->firstname);
        $user->setAddress($faker->streetAddress);
        $user->setZipcode(str_replace(' ','',$faker->postcode));
        $user->setCity($faker->city);
        $user->setPassword(
            $this->passwordEncoder->hashPassword($user, 'secret'));
       
        
        $manager->persist($user);
        }

        $manager->flush();
    }
}
