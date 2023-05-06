<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428185253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF9C07354F FOREIGN KEY (artiste) REFERENCES artiste (id_artiste)');
        $this->addSql('DROP INDEX artiste ON formation');
        $this->addSql('CREATE UNIQUE INDEX artist ON formation (artiste)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF9C07354F');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF9C07354F');
        $this->addSql('DROP INDEX artist ON formation');
        $this->addSql('CREATE UNIQUE INDEX artiste ON formation (artiste)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF9C07354F FOREIGN KEY (artiste) REFERENCES artiste (id_artiste)');
    }
}
