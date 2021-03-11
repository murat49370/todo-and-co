<?php


namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $user = new User();
        $task = new Task();


        $user->setUsername('user');
        $user->setEmail('user@mail.com');
        $user->setPassword('123456');
        $user->setRoles(['ROLE_USER']);
        $user->addTask($task);

        $this->assertEquals('user@mail.com', $user->getEmail());
        $this->assertEquals($task, $user->getTasks()[0]);

        $this->assertEquals('user', $user->getUsername());
        $this->assertEquals('123456', $user->getPassword());
        $this->assertEquals(null, $user->getSalt());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());

    }

    public function testRemoveTask()
    {
        $user = new User();
        $task = new Task();
        $user->addTask($task);

        $user->removeTask($task);
        $this->assertEquals(null, $user->getTasks()[0]);
    }

}