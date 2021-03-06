<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215111644 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE city DROP CONSTRAINT fk_2d5b0234f92f3e70');
        $this->addSql('DROP SEQUENCE greeting_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE passenger_flight_luggage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE terminal_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE country_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE city_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE TABLE flight_luggage (flight_id INT NOT NULL, luggage_id INT NOT NULL, PRIMARY KEY(flight_id, luggage_id))');
        $this->addSql('CREATE INDEX IDX_DAEB2B4C91F478C5 ON flight_luggage (flight_id)');
        $this->addSql('CREATE INDEX IDX_DAEB2B4C7B18BD6A ON flight_luggage (luggage_id)');
        $this->addSql('ALTER TABLE flight_luggage ADD CONSTRAINT FK_DAEB2B4C91F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_luggage ADD CONSTRAINT FK_DAEB2B4C7B18BD6A FOREIGN KEY (luggage_id) REFERENCES luggage (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE greeting');
        $this->addSql('DROP TABLE terminal');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE passenger_flight_luggage');
        $this->addSql('DROP TABLE country');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE greeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE passenger_flight_luggage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE terminal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE country_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE city_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE greeting (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE terminal (id INT NOT NULL, reference VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE city (id INT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_2d5b0234f92f3e70 ON city (country_id)');
        $this->addSql('CREATE TABLE passenger_flight_luggage (id INT NOT NULL, passenger_id INT DEFAULT NULL, flight_id INT DEFAULT NULL, luggage_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_ea27d6cd7b18bd6a ON passenger_flight_luggage (luggage_id)');
        $this->addSql('CREATE INDEX idx_ea27d6cd91f478c5 ON passenger_flight_luggage (flight_id)');
        $this->addSql('CREATE INDEX idx_ea27d6cd4502e565 ON passenger_flight_luggage (passenger_id)');
        $this->addSql('CREATE TABLE country (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT fk_2d5b0234f92f3e70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE passenger_flight_luggage ADD CONSTRAINT fk_ea27d6cd4502e565 FOREIGN KEY (passenger_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE passenger_flight_luggage ADD CONSTRAINT fk_ea27d6cd91f478c5 FOREIGN KEY (flight_id) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE passenger_flight_luggage ADD CONSTRAINT fk_ea27d6cd7b18bd6a FOREIGN KEY (luggage_id) REFERENCES luggage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE flight_luggage');
    }
}
