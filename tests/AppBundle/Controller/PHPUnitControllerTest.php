<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Task;
use PHPUnit\Framework\TestCase;

class PHPUnitControllerTest extends TestCase
{
    public function testIndex()
    {
        $task = new Task();
        
        $this->assertSame(false, $task->isDone());
    }
}
