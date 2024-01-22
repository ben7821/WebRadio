<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109093049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE podcast_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE audio_id_seq1 CASCADE');
        $this->addSql('DROP SEQUENCE equipe_id_seq1 CASCADE');
        $this->addSql('CREATE SEQUENCE inscr_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE info (id INT NOT NULL, nom VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE inscr (id INT NOT NULL, name VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE inscription (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE audio ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE emission ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE equipe ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE equipe ALTER description TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE inscr_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE podcast_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE audio_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE equipe_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE info');
        $this->addSql('DROP TABLE inscr');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('CREATE SEQUENCE audio_id_seq');
        $this->addSql('SELECT setval(\'audio_id_seq\', (SELECT MAX(id) FROM audio))');
        $this->addSql('ALTER TABLE audio ALTER id SET DEFAULT nextval(\'audio_id_seq\')');
        $this->addSql('ALTER TABLE emission ALTER description TYPE TEXT');
        $this->addSql('CREATE SEQUENCE equipe_id_seq');
        $this->addSql('SELECT setval(\'equipe_id_seq\', (SELECT MAX(id) FROM equipe))');
        $this->addSql('ALTER TABLE equipe ALTER id SET DEFAULT nextval(\'equipe_id_seq\')');
        $this->addSql('ALTER TABLE equipe ALTER description TYPE TEXT');
    }
}
