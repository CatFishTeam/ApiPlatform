<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215074424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE luggage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE airport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE journey_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE gate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE airlines_company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE flight_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE plane_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE brand_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE model (id INT NOT NULL, brand_id INT NOT NULL, reference VARCHAR(255) NOT NULL, number_of_seat INT NOT NULL, weight DOUBLE PRECISION NOT NULL, length DOUBLE PRECISION NOT NULL, width DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D79572D944F5D008 ON model (brand_id)');
        $this->addSql('CREATE TABLE user_account (id INT NOT NULL, address_id INT DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, birthdate TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, roles JSON DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_253B48AEF5B7AF75 ON user_account (address_id)');
        $this->addSql('COMMENT ON COLUMN user_account.roles IS \'(DC2Type:json_array)\'');
        $this->addSql('CREATE TABLE luggage (id INT NOT NULL, passenger_id INT DEFAULT NULL, number INT NOT NULL, weight DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5907C8DA4502E565 ON luggage (passenger_id)');
        $this->addSql('CREATE TABLE airport (id INT NOT NULL, location_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E91F7C264D218E ON airport (location_id)');
        $this->addSql('CREATE TABLE journey (id INT NOT NULL, reference VARCHAR(255) NOT NULL, starting_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ending_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE journey_flight (journey_id INT NOT NULL, flight_id INT NOT NULL, PRIMARY KEY(journey_id, flight_id))');
        $this->addSql('CREATE INDEX IDX_70B89AA8D5C9896F ON journey_flight (journey_id)');
        $this->addSql('CREATE INDEX IDX_70B89AA891F478C5 ON journey_flight (flight_id)');
        $this->addSql('CREATE TABLE gate (id INT NOT NULL, number VARCHAR(255) NOT NULL, terminal VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE airlines_company (id INT NOT NULL, headquarter_location_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C7FAFD5AB29CD850 ON airlines_company (headquarter_location_id)');
        $this->addSql('CREATE TABLE flight (id INT NOT NULL, plane_id INT DEFAULT NULL, gate_id INT DEFAULT NULL, airport_departure_id INT DEFAULT NULL, airport_destination_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, departure_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, arrival_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C257E60EF53666A8 ON flight (plane_id)');
        $this->addSql('CREATE INDEX IDX_C257E60E897F2CF6 ON flight (gate_id)');
        $this->addSql('CREATE INDEX IDX_C257E60E90E8127C ON flight (airport_departure_id)');
        $this->addSql('CREATE INDEX IDX_C257E60E79BEF85D ON flight (airport_destination_id)');
        $this->addSql('CREATE TABLE flight_user (flight_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(flight_id, user_id))');
        $this->addSql('CREATE INDEX IDX_CAD8B2E91F478C5 ON flight_user (flight_id)');
        $this->addSql('CREATE INDEX IDX_CAD8B2EA76ED395 ON flight_user (user_id)');
        $this->addSql('CREATE TABLE location (id INT NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE plane (id INT NOT NULL, model_id INT NOT NULL, airlines_company_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C1B32D807975B7E7 ON plane (model_id)');
        $this->addSql('CREATE INDEX IDX_C1B32D80FB10EA63 ON plane (airlines_company_id)');
        $this->addSql('CREATE TABLE brand (id INT NOT NULL, name VARCHAR(255) NOT NULL, founded_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_account ADD CONSTRAINT FK_253B48AEF5B7AF75 FOREIGN KEY (address_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE luggage ADD CONSTRAINT FK_5907C8DA4502E565 FOREIGN KEY (passenger_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C264D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE journey_flight ADD CONSTRAINT FK_70B89AA8D5C9896F FOREIGN KEY (journey_id) REFERENCES journey (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE journey_flight ADD CONSTRAINT FK_70B89AA891F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE airlines_company ADD CONSTRAINT FK_C7FAFD5AB29CD850 FOREIGN KEY (headquarter_location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EF53666A8 FOREIGN KEY (plane_id) REFERENCES plane (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E897F2CF6 FOREIGN KEY (gate_id) REFERENCES gate (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E90E8127C FOREIGN KEY (airport_departure_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E79BEF85D FOREIGN KEY (airport_destination_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_user ADD CONSTRAINT FK_CAD8B2E91F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_user ADD CONSTRAINT FK_CAD8B2EA76ED395 FOREIGN KEY (user_id) REFERENCES user_account (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plane ADD CONSTRAINT FK_C1B32D807975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plane ADD CONSTRAINT FK_C1B32D80FB10EA63 FOREIGN KEY (airlines_company_id) REFERENCES airlines_company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE plane DROP CONSTRAINT FK_C1B32D807975B7E7');
        $this->addSql('ALTER TABLE luggage DROP CONSTRAINT FK_5907C8DA4502E565');
        $this->addSql('ALTER TABLE flight_user DROP CONSTRAINT FK_CAD8B2EA76ED395');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E90E8127C');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E79BEF85D');
        $this->addSql('ALTER TABLE journey_flight DROP CONSTRAINT FK_70B89AA8D5C9896F');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E897F2CF6');
        $this->addSql('ALTER TABLE plane DROP CONSTRAINT FK_C1B32D80FB10EA63');
        $this->addSql('ALTER TABLE journey_flight DROP CONSTRAINT FK_70B89AA891F478C5');
        $this->addSql('ALTER TABLE flight_user DROP CONSTRAINT FK_CAD8B2E91F478C5');
        $this->addSql('ALTER TABLE user_account DROP CONSTRAINT FK_253B48AEF5B7AF75');
        $this->addSql('ALTER TABLE airport DROP CONSTRAINT FK_7E91F7C264D218E');
        $this->addSql('ALTER TABLE airlines_company DROP CONSTRAINT FK_C7FAFD5AB29CD850');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60EF53666A8');
        $this->addSql('ALTER TABLE model DROP CONSTRAINT FK_D79572D944F5D008');
        $this->addSql('DROP SEQUENCE model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_account_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE luggage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE airport_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE journey_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE gate_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE airlines_company_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE flight_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE location_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE plane_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE brand_id_seq CASCADE');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE user_account');
        $this->addSql('DROP TABLE luggage');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE journey');
        $this->addSql('DROP TABLE journey_flight');
        $this->addSql('DROP TABLE gate');
        $this->addSql('DROP TABLE airlines_company');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE flight_user');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE plane');
        $this->addSql('DROP TABLE brand');
    }
}
