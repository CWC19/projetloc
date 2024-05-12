<?php

namespace App\Tests\Functional;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AvisTest extends WebTestCase
{
    public function testAddAvis(): void
    {
            // Créer un client
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        // Trouver un utilisateur existant pour les tests
        $user = $entityManager->find(Utilisateur::class, 7); // Remplacez 8 par l'ID de l'utilisateur approprié

        // Se connecter en tant qu'utilisateur
        $client->loginUser($user);

        // Accéder à la page d'ajout d'avis
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_avis_new'));

        // Remplir le formulaire d'ajout d'avis
        $form = $crawler->filter('form[name=avis]')->form([
            'avis[texte]' => 'Ceci est un commentaire de test.',
            'avis[date_p]' => '11/05/2024',
            'avis[note]' => '3',
            'avis[auteur]' => '7',
        ]);

        // Soumettre le formulaire
        $client->submit($form);

        // Vérifier que la réponse est une redirection vers la page d'index des avis
        $this->assertResponseRedirects($urlGenerator->generate('app_avis_index'));

        // Suivre la redirection
        $client->followRedirect();

        // Vérifier que la page d'index des avis est affichée
        $this->assertResponseIsSuccessful();
    }
}
