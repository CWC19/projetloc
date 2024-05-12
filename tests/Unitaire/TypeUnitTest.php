<?php

namespace App\Tests\Unitaire;

use App\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TypeUnitTest extends KernelTestCase
{
    public function testSetMarque(): void
    {
        // 1. Créer un objet de l'entité à tester
        $entity = new Type(); 

        // 2. Appeler la méthode setMarque() 
        $marqueTest = "Marque de test";
        $entity->setMarque($marqueTest);

        // 3. Vérifier si la valeur de marque a été correctement définie
        $this->assertSame($marqueTest, $entity->getMarque());
        }

        public function testSetModele(): void
        {
            // 1. Créer un objet de l'entité à tester
            $entity = new Type(); 

            // 2. Appelle de la méthode setModele()
            $modelTest = "Modèle de test";
            $entity->setModel($modelTest);

            // 3. Vérifier si la valeur de modele a été correctement définie
            $this->assertSame($modelTest, $entity->getModel());
        }
}
