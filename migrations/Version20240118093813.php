<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118093813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant_emission DROP CONSTRAINT fk_fe63d9099d1c3019');
        $this->addSql('ALTER TABLE participant_emission DROP CONSTRAINT fk_fe63d90917e24d70');
        $this->addSql('DROP TABLE participant_emission');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE participant_emission (participant_id INT NOT NULL, emission_id INT NOT NULL, PRIMARY KEY(participant_id, emission_id))');
        $this->addSql('CREATE INDEX idx_fe63d90917e24d70 ON participant_emission (emission_id)');
        $this->addSql('CREATE INDEX idx_fe63d9099d1c3019 ON participant_emission (participant_id)');
        $this->addSql('ALTER TABLE participant_emission ADD CONSTRAINT fk_fe63d9099d1c3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant_emission ADD CONSTRAINT fk_fe63d90917e24d70 FOREIGN KEY (emission_id) REFERENCES emission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
