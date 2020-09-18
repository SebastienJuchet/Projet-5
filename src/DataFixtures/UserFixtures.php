<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('dyonisos40games@gmail.com');
    
        $password = $this->encoder->encodePassword($user, 'azerty');
        $user->setPassword($password);
        
        $user2 = new User();
        $user2->setEmail('test@gmail.com');
    
        $user2->setPassword($password);

        $manager->persist($user);
        $manager->persist($user2);
        $manager->flush();
    }
}
