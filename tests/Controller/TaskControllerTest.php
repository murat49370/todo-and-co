<?php


namespace App\Tests\Controller;


use App\DataFixtures\AppFixtures;
use App\Repository\UserRepository;
use App\Tests\NeedLogin;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    use FixturesTrait;
    use NeedLogin;

    public function testLetAuthenticatedUserAccessTaskDoneList()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user1']);

        $this->login($client, $user);

        $client->request('GET', '/tasks/done');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }


    public function testLetAuthenticatedUserAccessTask()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user1']);

        $this->login($client, $user);

        $client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedUserAccessTaskCreateForm()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user1']);

        $this->login($client, $user);

        $client->request('GET', '/tasks/create');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedUserAccessTaskEdit()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user']);

        $this->login($client, $user);

        $client->request('GET', '/tasks/1/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedUserAccessTaskToggle()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user']);

        $this->login($client, $user);

        $client->request('GET', '/tasks/1/toggle');
        $this->assertResponseRedirects('');
        //$this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLetAuthenticatedUserAccessTaskDelete()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user']);

        $this->login($client, $user);

        $client->request('GET', '/tasks/1/delete');
        $this->assertResponseRedirects('');
        //$this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testClickButtonListTasksToDo()
    {
        $client = static::createClient();
        $this->loadFixtures([AppFixtures::class]);
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneBy(['username' => 'user']);

        $this->login($client, $user);

        $crawler = $client->request('GET', '/');

        self::assertContains('/tasks', $crawler->filter('a')->extract(['href']));

        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $client->click($link);
        //$this->assertResponseRedirects('');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);


    }

}