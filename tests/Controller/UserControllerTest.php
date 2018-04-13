<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;


/**
 * @covers App\Controller\UserController
 */
class UserControllerTest extends WebTestCase
{

    /** @var  Client $client */
    protected $client;

    /** @var  Client $admin */
    protected $admin;

    public function setUp()
    {
        $this->client=static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $this->admin=static::createClient(array(), array('PHP_AUTH_USER' => 'Admin', 'PHP_AUTH_PW'   => 'Admin'));
        $this->logIn($this->client);
        $this->logIn($this->admin);

    }

    private function logIn($client)
    {
        $session = $client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'secured_area';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    /**
     * @covers App\Controller\UserController::listAction
     */
    public function testListAction()
    {
        $crawler = $this->admin->request('GET', '/users');
        $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame("Liste des utilisateurs", $crawler->filter('h1')->first()->text());
    }

    /*public function testCreateAction()
    {
        $crawler = $this->client->request('GET', '/users/create');
		
		$form = $crawler->filter('Button')->form();
		$crawler = $this->client->submit($form, array(
			'user[username]'  => 'Test_create',
			'user[password][first]'  => 'Test_create',
			'user[password][second]'  => 'Test_create',
			'user[email]'  => 'Test_create@yopmail.com',
		));
		$this->assertTrue($this->client->getResponse()->isRedirect('/users'));
		$crawler = $this->client->followRedirect();

        $this->assertSame("Liste des utilisateurs", $crawler->filter('h1')->first()->text());
    }*/

    public function testEditAction()
    {
        $crawler = $this->admin->request('GET', '/users/29/edit');
        $this->client->request('GET', '/users/29/edit');
        $this->assertEquals(404, $this->admin->getResponse()->getStatusCode());
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());

        $crawler = $this->admin->request('GET', '/users/2/edit');
		
		$form = $crawler->filter('Button')->form();
		$crawler = $this->admin->submit($form, array(
			'user[username]'  => 'Test_edit',
			'user[password][first]'  => 'Test_edit',
			'user[password][second]'  => 'Test_edit',
			'user[email]'  => 'Test_edit@yopmail.com',
		));
		$this->assertTrue($this->admin->getResponse()->isRedirect('/users'));
		$crawler = $this->admin->followRedirect();

        $this->assertContains("utilisateur a bien été modifié", $crawler->filter('.alert-success')->first()->text());
    }
}
