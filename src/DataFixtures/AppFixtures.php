<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
 
public function __construct(UserPasswordHasherInterface $hasher)
  {
      $this->hasher = $hasher;
  }

  public function load(ObjectManager $manager)
  {
      $user = new User();
      $user->setEmail("user@gmail.com");
      $password = $this->hasher->hashPassword($user, '123456');
      $user->setPassword($password);
      $user->setFname("Sebast");
      $user ->setLname("Schweinsteiger");
      $user ->setDateOfBirth(new \DateTime("1995-11-07"));
      $user ->setPhone("+658945");
      $user ->setGender("male");
      $user ->setBlocked(false);
      $user ->setImage("picture.jpg");




        


      $manager->persist($user);
      $manager->flush();
  }
}