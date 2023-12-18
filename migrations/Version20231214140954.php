<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214140954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, idjournal_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, auteur VARCHAR(255) NOT NULL, date DATE NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E668A279538 ON article (idjournal_id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E668A279538 FOREIGN KEY (idjournal_id) REFERENCES journal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E668A279538');
        $this->addSql('DROP TABLE article');
    }
}
