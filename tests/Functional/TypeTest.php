<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TypeTest extends WebTestCase
{

    public function testIndex(): void
    {
        $client = static::createClient();

        $client->request('GET', '/type/');

        // Vérifiez que la réponse est une redirection vers la page de connexion
        $this->assertResponseRedirects('/login');

        // Suivez la redirection vers la page de connexion
        $crawler = $client->followRedirect();

        // Vérifiez que la page de connexion est affichée
        $this->assertResponseIsSuccessful();
        

        // Maintenant, connectez-vous avec un utilisateur admin
        $client->submitForm('Connexion', [
            'email' => 'admin2@gmail.com', // Remplacez par l'email de l'utilisateur admin
            'password' => 'Admin10052024@', // Remplacez par le mot de passe de l'utilisateur admin
        ]);

        // Vérifiez que la connexion a réussi
        $this->assertResponseRedirects('/type/');

        // Suivez la redirection vers la page d'index des types
        $client->followRedirect();

        // Vérifiez que la page d'index des types est affichée
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Type liste');
    }

}


