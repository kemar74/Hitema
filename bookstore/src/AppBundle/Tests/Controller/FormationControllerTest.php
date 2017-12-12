<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormationControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/formations');
    }

    public function testCreation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/formation/creation');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/formation/{slug}');
    }

}
