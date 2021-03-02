<?php


namespace App\Tests\Controller;



use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    public function testHomePageRedirectToLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testAuthPageIsRestricted()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/users/create');
        $this->assertResponseRedirects('/login');
    }


}