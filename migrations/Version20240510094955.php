<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510094955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table "avis"';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable('avis')) {
            $this->addSql('CREATE TABLE avis (
                id INT AUTO_INCREMENT NOT NULL, 
                date_p DATE, 
                note DOUBLE, 
                texte TEXT, 
                auteur_id INT NOT NULL,
                PRIMARY KEY(id),
                CONSTRAINT FK_avis_auteur FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur CHANGE permis permis VARCHAR(254) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur CHANGE permis permis VARCHAR(255) NOT NULL');
        $this->addSql('DROP TABLE avis');
    }
}
