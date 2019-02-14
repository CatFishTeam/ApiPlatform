<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190214101604 extends AbstractMigration
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
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE location (id INT NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE terminal');
        $this->addSql('ALTER TABLE journey ADD starting_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE journey ADD ending_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE journey ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE journey ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('DROP INDEX idx_b82b9894e77b6ce8');
        $this->addSql('ALTER TABLE gate DROP terminal_id');
        $this->addSql('ALTER TABLE user_account ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_account ADD phone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_account ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE user_account ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE user_account ADD CONSTRAINT FK_253B48AEF5B7AF75 FOREIGN KEY (address_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_253B48AEF5B7AF75 ON user_account (address_id)');
        $this->addSql('ALTER TABLE flight ADD departure_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE flight ADD arrival_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE flight ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE flight ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE airport DROP CONSTRAINT fk_7e91f7c2f92f3e70');
        $this->addSql('ALTER TABLE airport DROP CONSTRAINT fk_7e91f7c28bac62af');
        $this->addSql('DROP INDEX idx_7e91f7c28bac62af');
        $this->addSql('DROP INDEX idx_7e91f7c2f92f3e70');
        $this->addSql('ALTER TABLE airport DROP city_id');
        $this->addSql('ALTER TABLE airport RENAME COLUMN country_id TO location_id');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C264D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E91F7C264D218E ON airport (location_id)');
        $this->addSql('ALTER TABLE brand ADD founded_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_account DROP CONSTRAINT FK_253B48AEF5B7AF75');
        $this->addSql('ALTER TABLE airport DROP CONSTRAINT FK_7E91F7C264D218E');
        $this->addSql('DROP SEQUENCE location_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE terminal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE terminal (id INT NOT NULL, reference VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE location');
        $this->addSql('ALTER TABLE brand DROP founded_at');
        $this->addSql('DROP INDEX IDX_253B48AEF5B7AF75');
        $this->addSql('ALTER TABLE user_account DROP address_id');
        $this->addSql('ALTER TABLE user_account DROP phone');
        $this->addSql('ALTER TABLE user_account DROP created_at');
        $this->addSql('ALTER TABLE user_account DROP updated_at');
        $this->addSql('ALTER TABLE gate ADD terminal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gate ADD CONSTRAINT fk_b82b9894e77b6ce8 FOREIGN KEY (terminal_id) REFERENCES terminal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b82b9894e77b6ce8 ON gate (terminal_id)');
        $this->addSql('DROP INDEX UNIQ_7E91F7C264D218E');
        $this->addSql('ALTER TABLE airport ADD city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE airport RENAME COLUMN location_id TO country_id');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT fk_7e91f7c2f92f3e70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT fk_7e91f7c28bac62af FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7e91f7c28bac62af ON airport (city_id)');
        $this->addSql('CREATE INDEX idx_7e91f7c2f92f3e70 ON airport (country_id)');
        $this->addSql('ALTER TABLE journey DROP starting_date');
        $this->addSql('ALTER TABLE journey DROP ending_date');
        $this->addSql('ALTER TABLE journey DROP created_at');
        $this->addSql('ALTER TABLE journey DROP updated_at');
        $this->addSql('ALTER TABLE flight DROP departure_date');
        $this->addSql('ALTER TABLE flight DROP arrival_date');
        $this->addSql('ALTER TABLE flight DROP created_at');
        $this->addSql('ALTER TABLE flight DROP updated_at');
    }
}
