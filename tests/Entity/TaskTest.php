<?php


namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;


class TaskTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $createdAt = new \DateTime();
        $user = new User();

        $task = new Task();
        $task->setTitle('My title');
        $task->setContent('My content');
        $task->setCreatedAt($createdAt);
        $task->setUser($user);

        $this->assertEquals('My title', $task->getTitle());
        $this->assertEquals('My content', $task->getContent());
        $this->assertEquals($createdAt, $task->getCreatedAt());
        $this->assertEquals($user, $task->getUser());
        $this->assertEquals(false, $task->isDone());
    }

    public function testStateChange()
    {
        $task = new Task();
        $task->toggle(true);

        $this->assertEquals(true, $task->isDone());
    }

}