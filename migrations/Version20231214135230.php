<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214135230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE utilisateur_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE lycee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE lycee (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, codep VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, voie VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE utilisateur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE lycee_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE utilisateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL, login VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE lycee');
    }
}
