<?php


namespace App\DataFixtures;


use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use PHPUnit\Framework\TestCase;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @codeCoverageIgnore
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @codeCoverageIgnore
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 9; $i++)
        {
            $user = new User();
            $user->setEmail("user$i@domain.fr");
            $user->setUsername("user$i");
            $user->setPassword($this->passwordEncoder->encodePassword($user, '123456'));
            $manager->persist($user);
        }

        $userUser = new User();
        $userUser->setEmail("user@domain.fr");
        $userUser->setUsername("user");
        $userUser->setPassword($this->passwordEncoder->encodePassword($userUser, '123456'));
        $manager->persist($userUser);

        $adminUser = new User();
        $adminUser->setRoles(["ROLE_ADMIN"]);
        $adminUser->setPassword($this->passwordEncoder->encodePassword($adminUser, '123456'));
        $adminUser->setUsername('admin');
        $adminUser->setEmail('admin@admin.com');
        $manager->persist($adminUser);

        $task = new Task();
        $task->setUser($userUser);
        $task->setTitle('Test task title');
        $task->setContent('Test content create task');
        $manager->persist($task);

        $manager->flush();
    }
}