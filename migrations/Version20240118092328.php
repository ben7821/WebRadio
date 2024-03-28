<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118092328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participant_emission (participant_id INT NOT NULL, emission_id INT NOT NULL, PRIMARY KEY(participant_id, emission_id))');
        $this->addSql('CREATE INDEX IDX_FE63D9099D1C3019 ON participant_emission (participant_id)');
        $this->addSql('CREATE INDEX IDX_FE63D90917E24D70 ON participant_emission (emission_id)');
        $this->addSql('ALTER TABLE participant_emission ADD CONSTRAINT FK_FE63D9099D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant_emission ADD CONSTRAINT FK_FE63D90917E24D70 FOREIGN KEY (emission_id) REFERENCES emission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE participant_emission DROP CONSTRAINT FK_FE63D9099D1C3019');
        $this->addSql('ALTER TABLE participant_emission DROP CONSTRAINT FK_FE63D90917E24D70');
        $this->addSql('DROP TABLE participant_emission');
    }
}
