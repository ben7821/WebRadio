<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123131726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription_participant DROP CONSTRAINT fk_20eef6c15dac5993');
        $this->addSql('ALTER TABLE inscription_participant DROP CONSTRAINT fk_20eef6c19d1c3019');
        $this->addSql('DROP TABLE inscription_participant');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE inscription_participant (inscription_id INT NOT NULL, participant_id INT NOT NULL, PRIMARY KEY(inscription_id, participant_id))');
        $this->addSql('CREATE INDEX idx_20eef6c19d1c3019 ON inscription_participant (participant_id)');
        $this->addSql('CREATE INDEX idx_20eef6c15dac5993 ON inscription_participant (inscription_id)');
        $this->addSql('ALTER TABLE inscription_participant ADD CONSTRAINT fk_20eef6c15dac5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription_participant ADD CONSTRAINT fk_20eef6c19d1c3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
