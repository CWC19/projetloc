<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131172151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, marque VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, puissance DOUBLE PRECISION NOT NULL, carburant VARCHAR(255) NOT NULL, boite_vitesse VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, immat VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, couleur VARCHAR(255) NOT NULL, INDEX IDX_E9E2810FC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE pays pays JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FC54C8C93');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('ALTER TABLE utilisateur CHANGE pays pays VARCHAR(255) DEFAULT NULL');
    }
}
