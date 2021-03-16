<?php


namespace App\Tests\Controller;


use App\DataFixtures\AppFixtures;
use App\Repository\UserRepository;
use App\Tests\NeedLogin;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{

    use FixturesTrait;
    use NeedLogin;


    public function testLetAuthenticatedAdminAccessAddUser()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'admin']);

        $this->login($client, $user);

        $client->request('GET', '/admin/users/create');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedAdminAccessUserList()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'admin']);

        $this->login($client, $user);

        $client->request('GET', '/admin/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedAdminAccessUserEdit()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'admin']);

        $this->login($client, $user);

        $client->request('GET', '/admin/users/1/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedAdminAccessUserEditFormSubmitOk()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'admin']);

        $this->login($client, $user);

        $crawler = $client->request('GET', '/admin/users/1/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Modifier')->form([
            'user_edit[username]' => 'userTest',
            'user_edit[email]' => 'email@email.com',
            'user_edit[roles]' => 'ROLE_USER'
        ]);
        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success');

    }

    public function testLetAuthenticatedAdminAccessUserCreateFormSubmitOk()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'admin']);

        $this->login($client, $user);

        $crawler = $client->request('GET', '/admin/users/create');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => 'userTest',
            'user[password][first]' => '123456',
            'user[password][second]' => '123456',
            'user[email]' => 'test@test.com',
            'user[roles]' => 'ROLE_USER'
        ]);
        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success');

    }





}