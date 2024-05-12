<?php

namespace App\Tests\Unitaire;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserUnitTest extends KernelTestCase
{
    public function testGetNom(): void
    {
        // Création d'un utilisateur
        $utilisateur = new Utilisateur();
        
        // Définition du nom de l'utilisateur
        $nomAttendu = 'John Doe';
        $utilisateur->setNom($nomAttendu);
        
        // Vérification que le nom est correctement récupéré
        $this->assertSame($nomAttendu, $utilisateur->getNom());
    }
    
    public function testSetEmail(): void
    {
        // Création d'un utilisateur
        $utilisateur = new Utilisateur();
        
        // Définition de l'email de l'utilisateur
        $emailAttendu = 'john.doe@example.com';
        $utilisateur->setEmail($emailAttendu);
        
        // Vérification que l'email est correctement récupéré
        $this->assertSame($emailAttendu, $utilisateur->getEmail());
    }

    public function testGetPrenom(): void
    {
        $utilisateur = new Utilisateur();
        
        // Définition du prénom de l'utilisateur
        $prenomAttendu = 'Jane';
        $utilisateur->setPrenom($prenomAttendu);
        
        // Vérification que le prénom est correctement récupéré
        $this->assertSame($prenomAttendu, $utilisateur->getPrenom());
    }
    
    public function testSetDof(): void
    {
        $utilisateur = new Utilisateur();
        
        // Définition de la date de naissance de l'utilisateur
        $dateNaissanceAttendue = new \DateTime('1990-01-01');
        $utilisateur->setDof($dateNaissanceAttendue);
        
        // Vérification que la date de naissance est correctement récupérée
        $this->assertEquals($dateNaissanceAttendue, $utilisateur->getDof());
    }

    public function testSetPermis(): void
    {
        $utilisateur = new Utilisateur();

        // Test avec un numéro de permis valide
        $numeroPermisValide = str_repeat('A', 30);
        $utilisateur->setPermis($numeroPermisValide);
        $this->assertSame($numeroPermisValide, $utilisateur->getPermis());

        // Test avec un numéro de permis invalide
        $numeroPermisInvalide = str_repeat('A', 29); // Moins de 30 caractères
        $this->expectException(\InvalidArgumentException::class);
        $utilisateur->setPermis($numeroPermisInvalide);
    }

}
