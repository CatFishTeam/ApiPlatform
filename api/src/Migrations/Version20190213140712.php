<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190213140712 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE journey_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE gate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE plane_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE terminal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE country_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE city_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE flight_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE luggage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE airport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE airlines_company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE journey (id INT NOT NULL, reference VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE journey_flight (journey_id INT NOT NULL, flight_id INT NOT NULL, PRIMARY KEY(journey_id, flight_id))');
        $this->addSql('CREATE INDEX IDX_70B89AA8D5C9896F ON journey_flight (journey_id)');
        $this->addSql('CREATE INDEX IDX_70B89AA891F478C5 ON journey_flight (flight_id)');
        $this->addSql('CREATE TABLE gate (id INT NOT NULL, terminal_id INT DEFAULT NULL, number VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B82B9894E77B6CE8 ON gate (terminal_id)');
        $this->addSql('CREATE TABLE plane (id INT NOT NULL, model_id INT NOT NULL, airlines_company_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C1B32D807975B7E7 ON plane (model_id)');
        $this->addSql('CREATE INDEX IDX_C1B32D80FB10EA63 ON plane (airlines_company_id)');
        $this->addSql('CREATE TABLE terminal (id INT NOT NULL, reference VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE country (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE city (id INT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2D5B0234F92F3E70 ON city (country_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, birthdate TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE flight (id INT NOT NULL, plane_id INT DEFAULT NULL, gate_id INT DEFAULT NULL, airport_departure_id INT DEFAULT NULL, airport_destination_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C257E60EF53666A8 ON flight (plane_id)');
        $this->addSql('CREATE INDEX IDX_C257E60E897F2CF6 ON flight (gate_id)');
        $this->addSql('CREATE INDEX IDX_C257E60E90E8127C ON flight (airport_departure_id)');
        $this->addSql('CREATE INDEX IDX_C257E60E79BEF85D ON flight (airport_destination_id)');
        $this->addSql('CREATE TABLE flight_user (flight_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(flight_id, user_id))');
        $this->addSql('CREATE INDEX IDX_CAD8B2E91F478C5 ON flight_user (flight_id)');
        $this->addSql('CREATE INDEX IDX_CAD8B2EA76ED395 ON flight_user (user_id)');
        $this->addSql('CREATE TABLE luggage (id INT NOT NULL, number INT NOT NULL, weight INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE model (id INT NOT NULL, brand_id INT NOT NULL, reference VARCHAR(255) NOT NULL, number_of_seat INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D79572D944F5D008 ON model (brand_id)');
        $this->addSql('CREATE TABLE airport (id INT NOT NULL, country_id INT NOT NULL, city_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E91F7C2F92F3E70 ON airport (country_id)');
        $this->addSql('CREATE INDEX IDX_7E91F7C28BAC62AF ON airport (city_id)');
        $this->addSql('CREATE TABLE brand (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE airlines_company (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE journey_flight ADD CONSTRAINT FK_70B89AA8D5C9896F FOREIGN KEY (journey_id) REFERENCES journey (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE journey_flight ADD CONSTRAINT FK_70B89AA891F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gate ADD CONSTRAINT FK_B82B9894E77B6CE8 FOREIGN KEY (terminal_id) REFERENCES terminal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plane ADD CONSTRAINT FK_C1B32D807975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plane ADD CONSTRAINT FK_C1B32D80FB10EA63 FOREIGN KEY (airlines_company_id) REFERENCES airlines_company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EF53666A8 FOREIGN KEY (plane_id) REFERENCES plane (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E897F2CF6 FOREIGN KEY (gate_id) REFERENCES gate (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E90E8127C FOREIGN KEY (airport_departure_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E79BEF85D FOREIGN KEY (airport_destination_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_user ADD CONSTRAINT FK_CAD8B2E91F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_user ADD CONSTRAINT FK_CAD8B2EA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C2F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C28BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE journey_flight DROP CONSTRAINT FK_70B89AA8D5C9896F');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E897F2CF6');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60EF53666A8');
        $this->addSql('ALTER TABLE gate DROP CONSTRAINT FK_B82B9894E77B6CE8');
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE airport DROP CONSTRAINT FK_7E91F7C2F92F3E70');
        $this->addSql('ALTER TABLE airport DROP CONSTRAINT FK_7E91F7C28BAC62AF');
        $this->addSql('ALTER TABLE flight_user DROP CONSTRAINT FK_CAD8B2EA76ED395');
        $this->addSql('ALTER TABLE journey_flight DROP CONSTRAINT FK_70B89AA891F478C5');
        $this->addSql('ALTER TABLE flight_user DROP CONSTRAINT FK_CAD8B2E91F478C5');
        $this->addSql('ALTER TABLE plane DROP CONSTRAINT FK_C1B32D807975B7E7');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E90E8127C');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E79BEF85D');
        $this->addSql('ALTER TABLE model DROP CONSTRAINT FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE plane DROP CONSTRAINT FK_C1B32D80FB10EA63');
        $this->addSql('DROP SEQUENCE journey_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE gate_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE plane_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE terminal_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE country_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE city_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE flight_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE luggage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE airport_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE brand_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE airlines_company_id_seq CASCADE');
        $this->addSql('DROP TABLE journey');
        $this->addSql('DROP TABLE journey_flight');
        $this->addSql('DROP TABLE gate');
        $this->addSql('DROP TABLE plane');
        $this->addSql('DROP TABLE terminal');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE flight_user');
        $this->addSql('DROP TABLE luggage');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE airlines_company');
    }
}
