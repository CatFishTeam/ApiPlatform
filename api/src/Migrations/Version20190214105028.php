<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190214105028 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE airlines_company ADD headquarter_location_id INT NOT NULL');
        $this->addSql('ALTER TABLE airlines_company ADD CONSTRAINT FK_C7FAFD5AB29CD850 FOREIGN KEY (headquarter_location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C7FAFD5AB29CD850 ON airlines_company (headquarter_location_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE airlines_company DROP CONSTRAINT FK_C7FAFD5AB29CD850');
        $this->addSql('DROP INDEX IDX_C7FAFD5AB29CD850');
        $this->addSql('ALTER TABLE airlines_company DROP headquarter_location_id');
    }
}
