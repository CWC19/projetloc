<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240508094724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF03C3B4EF0');
        $this->addSql('DROP INDEX IDX_8F91ABF03C3B4EF0 ON avis');
        $this->addSql('ALTER TABLE avis DROP reservation_id_id');
        $this->addSql('ALTER TABLE reservation CHANGE date_deb date_deb DATE DEFAULT NULL, CHANGE date_fin date_fin DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation CHANGE date_deb date_deb DATE NOT NULL, CHANGE date_fin date_fin DATE NOT NULL');
        $this->addSql('ALTER TABLE avis ADD reservation_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF03C3B4EF0 FOREIGN KEY (reservation_id_id) REFERENCES reservation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8F91ABF03C3B4EF0 ON avis (reservation_id_id)');
    }
}
