<?php

namespace App\Tests\Functional;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeTest extends WebTestCase
{

    public function testIndex(): void{
            $client = static::createClient();
            $urlGenerator = $client->getContainer()->get('router');
            $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
            $user = $entityManager->find(Utilisateur::class, 8); //user id 
            $client->loginUser($user);
            
            $crawler = $client->request(Request::METHOD_GET,$urlGenerator->generate('app_type_index'));
    
            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
            
        }
    

    public function testAddType(): void {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(Utilisateur::class, 8); //user id 
        $client->loginUser($user);
        
        $crawler = $client->request(Request::METHOD_GET,$urlGenerator->generate('app_type_new'));

        $form = $crawler->filter ('form[name=type]')->form([
            'type[marque]' => 'Déco',
            'type[model]' => 'Déco2',
            'type[puissance]' => '12',
            'type[carburant]' => 'Essence',
            'type[boite_vitesse]' => 'Automatique',
            'type[categorie]' => 'Sport',
        ]);
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_SEE_OTHER);
        $client->followRedirect();
        $this->assertRouteSame('app_type_index');
    }

}


