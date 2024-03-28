<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109094259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription ADD ems_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D668D39FE6 FOREIGN KEY (ems_id) REFERENCES emission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5E90F6D668D39FE6 ON inscription (ems_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE emission ALTER description TYPE TEXT');
        $this->addSql('ALTER TABLE inscription DROP CONSTRAINT FK_5E90F6D668D39FE6');
        $this->addSql('DROP INDEX IDX_5E90F6D668D39FE6');
        $this->addSql('ALTER TABLE inscription DROP ems_id');
    }
}
