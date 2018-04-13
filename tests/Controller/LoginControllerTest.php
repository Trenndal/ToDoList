<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;

class LoginControllerTest extends WebTestCase
{

    /** @var  Application $application */
    protected static $application;

    public static function setUpBeforeClass()
    {
        self::runCommand('doctrine:database:drop --env=test --force');
        self::runCommand('doctrine:database:create --env=test');
        self::runCommand('doctrine:schema:create --env=test');
        self::runCommand('doctrine:fixtures:load -n --env=test');

    }

    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }


    /** @var  Client $client */
    protected $client;

    /** @var  Client $user */
    protected $user;

    public function setUp()
    {
        $this->client=static::createClient(array(), array());
        $this->user=static::createClient(array(), array('PHP_AUTH_USER' => 'Test', 'PHP_AUTH_PW'   => 'Test'));
        $this->logIn($this->client);
        $this->logIn($this->user);

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

    public function testTaskAccess()
    {
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->request('GET', '/tasks/2/edit');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->request('GET', '/tasks/1/toggle');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->request('GET', '/tasks/2/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

    }

    public function testUserAccess()
    {
        $crawler = $this->client->request('GET', '/users');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->user->request('GET', '/users');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->request('GET', '/users/2/edit');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->user->request('GET', '/users/2/edit');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

    }

}
