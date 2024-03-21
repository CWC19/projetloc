<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310114805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD reservation_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF03C3B4EF0 FOREIGN KEY (reservation_id_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF03C3B4EF0 ON avis (reservation_id_id)');
        $this->addSql('ALTER TABLE voiture CHANGE photo1 photo1 VARCHAR(255) DEFAULT NULL, CHANGE photo2 photo2 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF03C3B4EF0');
        $this->addSql('DROP INDEX IDX_8F91ABF03C3B4EF0 ON avis');
        $this->addSql('ALTER TABLE avis DROP reservation_id_id');
        $this->addSql('ALTER TABLE voiture CHANGE photo1 photo1 VARCHAR(255) NOT NULL, CHANGE photo2 photo2 VARCHAR(255) NOT NULL');
    }
}
