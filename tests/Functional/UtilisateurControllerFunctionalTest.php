<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisateurControllerFunctionalTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/utilisateur/new');

        // Assert that the new utilisateur page returns a successful response
        $this->assertResponseIsSuccessful();

        // Assert that the new utilisateur form is rendered on the page
        $this->assertSelectorExists('form#utilisateur_form');

        // Fill out and submit the form with dummy data
        $form = $crawler->selectButton('Create')->form();
        $form['utilisateur[username]'] = 'test_user';
        $form['utilisateur[password]'] = 'test_password';
        // Include other required form fields

        // Submit the form
        $client->submit($form);

        // Assert that the user is redirected to the login page after successful registration
        $this->assertResponseRedirects('/login');
    }
}
