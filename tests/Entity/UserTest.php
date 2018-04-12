<?php

namespace Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testUsername()
    {
        $user = new User();
        
        $user->setUsername("Username");
        $this->assertSame("Username", $user->getUsername());
    }

    public function testPassword()
    {
        $user = new User();
        
        $user->setPassword("Password");
        $this->assertSame("Password", $user->getPassword());
    }

    public function testEmail()
    {
        $user = new User();
        
        $user->setEmail("Email");
        $this->assertSame("Email", $user->getEmail());
    }

    public function testRoles()
    {
        $user = new User();
        
        $Roles = array('ROLE_USER');
        //$user->setRoles($Roles);
        $this->assertSame($Roles, $user->getRoles());
    }
}
