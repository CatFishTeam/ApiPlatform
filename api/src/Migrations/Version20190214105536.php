<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190214105536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE luggage ADD passenger_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE luggage ADD CONSTRAINT FK_5907C8DA4502E565 FOREIGN KEY (passenger_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5907C8DA4502E565 ON luggage (passenger_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE luggage DROP CONSTRAINT FK_5907C8DA4502E565');
        $this->addSql('DROP INDEX UNIQ_5907C8DA4502E565');
        $this->addSql('ALTER TABLE luggage DROP passenger_id');
    }
}
