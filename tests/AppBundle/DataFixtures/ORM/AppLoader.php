<?php
// tests/AppBundle/DataFixtures/ORM/AppLoader.php

namespace Tests\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;

class AppLoader implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $listNames = array('Alexandre', 'Marine', 'Anna');

    foreach ($listNames as $name) {
        $user = new User();

        $user->setUsername($name);
        $user->setPassword($name);
        $user->setEmail($name . "@yopmail.com");

        //$user->setRoles(array('ROLE_USER'));

        $listTasks = array('Do this', 'Do that', 'Do nothing');
        foreach ($listTasks as $taskName) {
            $task = new Task();
            $task->setTitle($taskName);
            $task->setContent($taskName);
            //$task->setUser($user);
            if($taskName == "Do nothing") {
                $task->toggle(true);
            }
            //$user->addTask($task);
            $manager->persist($task);
        }

        $manager->persist($user);
    }

    $manager->flush();
  }
}
