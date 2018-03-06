<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    public function testListAction()
    {
        $client = static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $crawler = $client->request('GET', '/users');

        $this->assertSame("Liste des utilisateurs", $crawler->filter('h1')->first()->text());
    }

    public function testCreateAction()
    {
        $client = static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $crawler = $client->request('GET', '/users/create');
		
		$form = $crawler->filter('Button')->form();
		$crawler = $client->submit($form, array(
			'user[username]'  => 'Test_create',
			'user[password][first]'  => 'Test_create',
			'user[password][second]'  => 'Test_create',
			'user[email]'  => 'Test_create@yopmail.com',
		));
		$this->assertTrue($client->getResponse()->isRedirect('/users'));
		$crawler = $client->followRedirect();

        $this->assertSame("Liste des utilisateurs", $crawler->filter('h1')->first()->text());
    }

    public function testEditAction()
    {
        $client = static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $crawler = $client->request('GET', '/users/2/edit');
		
		$form = $crawler->filter('Button')->form();
		$crawler = $client->submit($form, array(
			'user[username]'  => 'Test_edit',
			'user[password][first]'  => 'Test_edit',
			'user[password][second]'  => 'Test_edit',
			'user[email]'  => 'Test_edit@yopmail.com',
		));
		$this->assertTrue($client->getResponse()->isRedirect('/users'));
		$crawler = $client->followRedirect();

        $this->assertContains("utilisateur a bien été modifié", $crawler->filter('.alert-success')->first()->text());
    }
}
