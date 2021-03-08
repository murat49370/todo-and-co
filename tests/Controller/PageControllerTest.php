<?php


namespace App\Tests\Controller;



use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\NeedLogin;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class PageControllerTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLogin;

    public function testHomePageRedirectAnonymousClient()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects();
    }

    public function testLetAuthenticatedUserAccessTask()
    {
        $client = static::createClient();
        $this->loadFixtures([UserFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user1']);

        $this->login($client, $user);

        $client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedAdminAccessAddUser()
    {
        $client = static::createClient();
        $this->loadFixtures([UserFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'admin']);

        $this->login($client, $user);

        $client->request('GET', '/admin/users/create');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedUserNotAccessAddUser()
    {
        $client = static::createClient();
        $this->loadFixtures([UserFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user1']);

        $this->login($client, $user);

        $client->request('GET', '/admin/users/create');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }







}