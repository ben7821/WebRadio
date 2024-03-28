<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118085131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP nom');
        $this->addSql('ALTER TABLE inscription DROP prenom');
        $this->addSql('ALTER TABLE inscription DROP tel');
        $this->addSql('ALTER TABLE inscription DROP mail');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE inscription ADD nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD prenom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD tel VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD mail VARCHAR(255) NOT NULL');
    }
}
