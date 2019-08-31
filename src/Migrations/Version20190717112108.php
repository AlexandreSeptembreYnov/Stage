<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190717112108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ouvrage (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, titre VARCHAR(255) NOT NULL, Auteur_id INT DEFAULT NULL, Theme_id INT DEFAULT NULL, INDEX IDX_52A8CBD8E24AED45 (Auteur_id), INDEX IDX_52A8CBD8A07416D1 (Theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ouvrage ADD CONSTRAINT FK_52A8CBD8E24AED45 FOREIGN KEY (Auteur_id) REFERENCES auteur (id)');
        $this->addSql('ALTER TABLE ouvrage ADD CONSTRAINT FK_52A8CBD8A07416D1 FOREIGN KEY (Theme_id) REFERENCES theme (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ouvrage DROP FOREIGN KEY FK_52A8CBD8E24AED45');
        $this->addSql('ALTER TABLE ouvrage DROP FOREIGN KEY FK_52A8CBD8A07416D1');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE ouvrage');
        $this->addSql('DROP TABLE theme');
    }
}
