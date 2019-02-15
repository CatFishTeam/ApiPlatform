<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215112809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE flight_luggage (flight_id INT NOT NULL, luggage_id INT NOT NULL, PRIMARY KEY(flight_id, luggage_id))');
        $this->addSql('CREATE INDEX IDX_DAEB2B4C91F478C5 ON flight_luggage (flight_id)');
        $this->addSql('CREATE INDEX IDX_DAEB2B4C7B18BD6A ON flight_luggage (luggage_id)');
        $this->addSql('ALTER TABLE flight_luggage ADD CONSTRAINT FK_DAEB2B4C91F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_luggage ADD CONSTRAINT FK_DAEB2B4C7B18BD6A FOREIGN KEY (luggage_id) REFERENCES luggage (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE flight_luggage');
    }
}
