<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122133630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription_participant (inscription_id INT NOT NULL, participant_id INT NOT NULL, PRIMARY KEY(inscription_id, participant_id))');
        $this->addSql('CREATE INDEX IDX_20EEF6C15DAC5993 ON inscription_participant (inscription_id)');
        $this->addSql('CREATE INDEX IDX_20EEF6C19D1C3019 ON inscription_participant (participant_id)');
        $this->addSql('ALTER TABLE inscription_participant ADD CONSTRAINT FK_20EEF6C15DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inscription_participant ADD CONSTRAINT FK_20EEF6C19D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE inscription_participant DROP CONSTRAINT FK_20EEF6C15DAC5993');
        $this->addSql('ALTER TABLE inscription_participant DROP CONSTRAINT FK_20EEF6C19D1C3019');
        $this->addSql('DROP TABLE inscription_participant');
    }
}
