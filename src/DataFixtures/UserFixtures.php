<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++)
        {
            $user = new User();
            $user->setEmail("user$i@domain.fr");
            $user->setUsername("user$i");
            $user->setPassword($this->passwordEncoder->encodePassword($user, '123456'));

            $manager->persist($user);
        }
        $manager->flush();
    }
}