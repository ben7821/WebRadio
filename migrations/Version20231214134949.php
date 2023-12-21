<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214134949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE inscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE inscription (id INT NOT NULL, idemission_id INT NOT NULL, nom VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, reponse VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E90F6D6D1233DDF ON inscription (idemission_id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6D1233DDF FOREIGN KEY (idemission_id) REFERENCES emission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE inscription_id_seq CASCADE');
        $this->addSql('ALTER TABLE inscription DROP CONSTRAINT FK_5E90F6D6D1233DDF');
        $this->addSql('DROP TABLE inscription');
    }
}
