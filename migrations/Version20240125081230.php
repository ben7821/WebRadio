<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240125081230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE participation_id_seq CASCADE');
        $this->addSql('ALTER TABLE participation DROP CONSTRAINT fk_ab55e24f9d1c3019');
        $this->addSql('ALTER TABLE participation DROP CONSTRAINT fk_ab55e24f5dac5993');
        $this->addSql('DROP TABLE participation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE participation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE participation (id INT NOT NULL, participant_id INT DEFAULT NULL, inscription_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_ab55e24f5dac5993 ON participation (inscription_id)');
        $this->addSql('CREATE INDEX idx_ab55e24f9d1c3019 ON participation (participant_id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT fk_ab55e24f9d1c3019 FOREIGN KEY (participant_id) REFERENCES participant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT fk_ab55e24f5dac5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
