<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123084034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant_participation DROP CONSTRAINT fk_2eadfad39d1c3019');
        $this->addSql('ALTER TABLE participant_participation DROP CONSTRAINT fk_2eadfad36ace3b73');
        $this->addSql('DROP TABLE participant_participation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE participant_participation (participant_id INT NOT NULL, participation_id INT NOT NULL, PRIMARY KEY(participant_id, participation_id))');
        $this->addSql('CREATE INDEX idx_2eadfad36ace3b73 ON participant_participation (participation_id)');
        $this->addSql('CREATE INDEX idx_2eadfad39d1c3019 ON participant_participation (participant_id)');
        $this->addSql('ALTER TABLE participant_participation ADD CONSTRAINT fk_2eadfad39d1c3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant_participation ADD CONSTRAINT fk_2eadfad36ace3b73 FOREIGN KEY (participation_id) REFERENCES participation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
