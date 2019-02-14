<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190214091516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE gate DROP CONSTRAINT fk_b82b9894e77b6ce8');
        $this->addSql('DROP SEQUENCE terminal_id_seq CASCADE');
        $this->addSql('DROP TABLE terminal');
        $this->addSql('DROP INDEX idx_b82b9894e77b6ce8');
        $this->addSql('ALTER TABLE gate DROP terminal_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE terminal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE terminal (id INT NOT NULL, reference VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE gate ADD terminal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gate ADD CONSTRAINT fk_b82b9894e77b6ce8 FOREIGN KEY (terminal_id) REFERENCES terminal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b82b9894e77b6ce8 ON gate (terminal_id)');
    }
}
