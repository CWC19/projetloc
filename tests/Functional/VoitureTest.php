<?php

namespace App\Tests\Functional;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VoitureTest extends WebTestCase
{
    public function testIndex(): void{
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(Utilisateur::class, 1); //user id 
        $client->loginUser($user);
        
        $crawler = $client->request(Request::METHOD_GET,$urlGenerator->generate('app_voiture_index'));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
    }
}
