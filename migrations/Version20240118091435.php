<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118091435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emission ADD participant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emission ADD CONSTRAINT FK_F0225CF49D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F0225CF49D1C3019 ON emission (participant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE emission DROP CONSTRAINT FK_F0225CF49D1C3019');
        $this->addSql('DROP INDEX IDX_F0225CF49D1C3019');
        $this->addSql('ALTER TABLE emission DROP participant_id');
    }
}
