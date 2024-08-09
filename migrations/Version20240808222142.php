<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240808222142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE average_annual_cost_per_person (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, elomrade VARCHAR(255) NOT NULL, average_cost_per_person DOUBLE PRECISION NOT NULL)');
        $this->addSql('DROP TABLE annual_cost_per_person');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annual_cost_per_person (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, elomrade VARCHAR(255) NOT NULL COLLATE "BINARY", annual_cost DOUBLE PRECISION NOT NULL)');
        $this->addSql('DROP TABLE average_annual_cost_per_person');
    }
}
