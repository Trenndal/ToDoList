<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{

    /** @var  Client $client */
    protected $client;

    public function setUp()
    {
        $this->client=static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $this->logIn($this->client);

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

    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('a:contains("Créer une tâche")')->count());
    }

    public function testCreateAction()
    {
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		
		$form = $crawler->filter('Button')->form();
		$crawler = $this->client->submit($form, array(
			'task[title]'  => 'Test create Task',
			'task[content]'  => 'Test create Task',
		));
		$this->assertTrue($this->client->getResponse()->isRedirect('/tasks'));
		$crawler = $this->client->followRedirect();

        $this->assertContains("La tâche a été bien été ajoutée.", $crawler->filter('.alert-success')->first()->text());
    }

    public function testEditAction()
    {
        $crawler = $this->client->request('GET', '/tasks/29/edit');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->request('GET', '/tasks/2/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		
		$form = $crawler->filter('Button')->form();
		$crawler = $this->client->submit($form, array(
			'task[title]'  => 'Test edit Task',
			'task[content]'  => 'Test edit Task',
		));
		$this->assertTrue($this->client->getResponse()->isRedirect('/tasks'));
		$crawler = $this->client->followRedirect();

        $this->assertContains("La tâche a bien été modifiée.", $crawler->filter('.alert-success')->first()->text());
    }

    public function testToggleTaskAction()
    {
        $crawler = $this->client->request('GET', '/tasks/1/toggle');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->request('GET', '/tasks/1/toggle');
		
		$this->assertTrue($this->client->getResponse()->isRedirect('/tasks'));
		$crawler = $this->client->followRedirect();

        $this->assertContains("a bien été marquée comme faite.", $crawler->filter('.alert-success')->first()->text());
    }

    public function testDeleteTaskAction()
    {
        $crawler = $this->client->request('GET', '/tasks/29/delete');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->request('GET', '/tasks/2/delete');
		
		$this->assertTrue($this->client->getResponse()->isRedirect('/tasks'));
		$crawler = $this->client->followRedirect();

        $this->assertContains("La tâche a bien été supprimée.", $crawler->filter('.alert-success')->first()->text());
    }
}
