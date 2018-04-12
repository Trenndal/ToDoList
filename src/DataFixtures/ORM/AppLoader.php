<?php
// src/DataFixtures/ORM/AppLoader.php

namespace App\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Task;

class AppLoader extends Fixture implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $listNames = array('Alexandre', 'Marine', 'Anna', 'Test');

    foreach ($listNames as $name) {
        $user = new User();

        $user->setUsername($name);
        $user->setPassword($name);
        $user->setEmail($name . "@yopmail.com");

        $user->setRoles(array('ROLE_USER'));

        $listTasks = array('Do this', 'Do that', 'Do nothing');
        foreach ($listTasks as $taskName) {
            $task = new Task();
            $task->setTitle($taskName);
            $task->setContent($taskName);
            
            $task->setUser($user);
            
            if($taskName == "Do nothing") {
                $task->toggle(true);
            }
            
            $user->addTask($task);
            
            $manager->persist($task);
        }

        $manager->persist($user);
    }

    $user = new User();
    $user->setUsername("Admin");
    $user->setPassword("Admin");
    $user->setEmail("Admin@yopmail.com");
    $user->setRoles(array('ROLE_ADMIN'));
    $manager->persist($user);

    $manager->flush();
  }
}
