<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240808123150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE average_cost_per_year');
        $this->addSql('DROP TABLE population_per_lan');
        $this->addSql('CREATE TEMPORARY TABLE __temp__population_per_elomrade AS SELECT id, year, elomrade, population FROM population_per_elomrade');
        $this->addSql('DROP TABLE population_per_elomrade');
        $this->addSql('CREATE TABLE population_per_elomrade (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, elorade VARCHAR(3) NOT NULL, population INTEGER NOT NULL)');
        $this->addSql('INSERT INTO population_per_elomrade (id, year, elorade, population) SELECT id, year, elomrade, population FROM __temp__population_per_elomrade');
        $this->addSql('DROP TABLE __temp__population_per_elomrade');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE average_cost_per_year (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, se1 DOUBLE PRECISION DEFAULT NULL, se2 DOUBLE PRECISION DEFAULT NULL, se3 DOUBLE PRECISION DEFAULT NULL, se4 DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('CREATE TABLE population_per_lan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, stockholm INTEGER DEFAULT NULL, uppsala INTEGER DEFAULT NULL, sodermanland INTEGER DEFAULT NULL, ostergotland INTEGER DEFAULT NULL, jonkoping INTEGER DEFAULT NULL, kronoberg INTEGER DEFAULT NULL, kalmar INTEGER DEFAULT NULL, gotland INTEGER DEFAULT NULL, blekinge INTEGER DEFAULT NULL, skane INTEGER DEFAULT NULL, halland INTEGER DEFAULT NULL, vastra_gotaland INTEGER DEFAULT NULL, varmland INTEGER DEFAULT NULL, orebro INTEGER DEFAULT NULL, vastmanland INTEGER DEFAULT NULL, dalarnas_lan INTEGER DEFAULT NULL, gavleborg INTEGER DEFAULT NULL, vasternorrland INTEGER DEFAULT NULL, jamtland INTEGER DEFAULT NULL, vasterbotten INTEGER DEFAULT NULL, norrbotten INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__population_per_elomrade AS SELECT id, year, elorade, population FROM population_per_elomrade');
        $this->addSql('DROP TABLE population_per_elomrade');
        $this->addSql('CREATE TABLE population_per_elomrade (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, elomrade VARCHAR(3) NOT NULL, population INTEGER NOT NULL)');
        $this->addSql('INSERT INTO population_per_elomrade (id, year, elomrade, population) SELECT id, year, elorade, population FROM __temp__population_per_elomrade');
        $this->addSql('DROP TABLE __temp__population_per_elomrade');
    }
}
