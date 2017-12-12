<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ModuleControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modules');
    }

    public function testCreation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/module/creation');
    }

}
