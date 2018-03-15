<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testIsDone()
    {
        $task = new Task();
        $this->assertSame(false, $task->isDone());
        
        $task->toggle(true);
        $this->assertSame(true, $task->isDone());
    }

    public function testContent()
    {
        $task = new Task();
        
        $task->setContent("Content");
        $this->assertSame("Content", $task->getContent());
    }

    public function testTitle()
    {
        $task = new Task();
        
        $task->setTitle("Title");
        $this->assertSame("Title", $task->getTitle());
    }

    public function testCreatedAt()
    {
        $task = new Task();
        
        $createdAt = new \Datetime();
        $task->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $task->getCreatedAt());
    }
}
