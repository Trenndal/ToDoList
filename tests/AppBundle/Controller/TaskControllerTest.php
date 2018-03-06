<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testListAction()
    {
        $client = static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $crawler = $client->request('GET', '/tasks');

        $this->assertSame(1, $crawler->filter('a:contains("Créer une tâche")')->count());
    }

    public function testCreateAction()
    {
        $client = static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $crawler = $client->request('GET', '/tasks/create');
		
		$form = $crawler->filter('Button')->form();
		$crawler = $client->submit($form, array(
			'task[title]'  => 'Test create Task',
			'task[content]'  => 'Test create Task',
		));
		$this->assertTrue($client->getResponse()->isRedirect('/tasks'));
		$crawler = $client->followRedirect();

        $this->assertContains("La tâche a été bien été ajoutée.", $crawler->filter('.alert-success')->first()->text());
    }

    public function testEditAction()
    {
        $client = static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $crawler = $client->request('GET', '/tasks/2/edit');
		
		$form = $crawler->filter('Button')->form();
		$crawler = $client->submit($form, array(
			'task[title]'  => 'Test edit Task',
			'task[content]'  => 'Test edit Task',
		));
		$this->assertTrue($client->getResponse()->isRedirect('/tasks'));
		$crawler = $client->followRedirect();

        $this->assertContains("La tâche a bien été modifiée.", $crawler->filter('.alert-success')->first()->text());
    }

    public function testToggleTaskAction()
    {
        $client = static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $crawler = $client->request('GET', '/tasks/1/toggle');
		
		$this->assertTrue($client->getResponse()->isRedirect('/tasks'));
		$crawler = $client->followRedirect();

        $this->assertContains("a bien été marquée comme faite.", $crawler->filter('.alert-success')->first()->text());
    }

    public function testDeleteTaskAction()
    {
        $client = static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $crawler = $client->request('GET', '/tasks/2/delete');
		
		$this->assertTrue($client->getResponse()->isRedirect('/tasks'));
		$crawler = $client->followRedirect();

        $this->assertContains("La tâche a bien été supprimée.", $crawler->filter('.alert-success')->first()->text());
    }
}
