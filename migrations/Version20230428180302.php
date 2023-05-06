<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428180302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artiste MODIFY id_artiste INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON artiste');
        $this->addSql('ALTER TABLE artiste CHANGE id_artiste id INT AUTO_INCREMENT NOT NULL, CHANGE mdp mpd VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE artiste ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX artiste ON artiste');
        $this->addSql('CREATE UNIQUE INDEX artist ON artiste (login)');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY artiste');
        $this->addSql('DROP INDEX artiste ON formation');
        $this->addSql('CREATE UNIQUE INDEX artist ON formation (artiste)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT artiste FOREIGN KEY (artiste) REFERENCES artiste (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artiste MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON artiste');
        $this->addSql('ALTER TABLE artiste CHANGE id id_artiste INT AUTO_INCREMENT NOT NULL, CHANGE mpd mdp VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE artiste ADD PRIMARY KEY (id_artiste)');
        $this->addSql('DROP INDEX artist ON artiste');
        $this->addSql('CREATE UNIQUE INDEX artiste ON artiste (login)');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF9C07354F');
        $this->addSql('DROP INDEX artist ON formation');
        $this->addSql('CREATE UNIQUE INDEX artiste ON formation (artiste)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF9C07354F FOREIGN KEY (artiste) REFERENCES artiste (login)');
    }
}
