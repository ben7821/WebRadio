<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214134743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE audio_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE audio (id INT NOT NULL, idemission_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, heure TIME(0) WITHOUT TIME ZONE NOT NULL, date DATE NOT NULL, audio VARCHAR(255) NOT NULL, auteurs VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_187D3695D1233DDF ON audio (idemission_id)');
        $this->addSql('ALTER TABLE audio ADD CONSTRAINT FK_187D3695D1233DDF FOREIGN KEY (idemission_id) REFERENCES emission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE audio_id_seq CASCADE');
        $this->addSql('ALTER TABLE audio DROP CONSTRAINT FK_187D3695D1233DDF');
        $this->addSql('DROP TABLE audio');
    }
}
