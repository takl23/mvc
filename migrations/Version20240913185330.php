<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240913185330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE average_annual_cost_per_person (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, elomrade VARCHAR(255) NOT NULL, average_cost_per_person DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE average_consumption (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, se1 DOUBLE PRECISION NOT NULL, se2 DOUBLE PRECISION NOT NULL, se3 DOUBLE PRECISION NOT NULL, se4 DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE consumption_per_capita (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, elomrade VARCHAR(255) NOT NULL, consumption_per_capita DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE electricity_price (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, se1 DOUBLE PRECISION NOT NULL, se2 DOUBLE PRECISION NOT NULL, se3 DOUBLE PRECISION NOT NULL, se4 DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE energy_consumption (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, se1 INTEGER NOT NULL, se2 INTEGER NOT NULL, se3 INTEGER NOT NULL, se4 INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE energy_supply_gdp (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, precentage DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE lan_elomrade (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lan VARCHAR(255) NOT NULL, elomrade VARCHAR(3) NOT NULL)');
        $this->addSql('CREATE TABLE library (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(13) NOT NULL, author VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A18098BCCC1CF4E6 ON library (isbn)');
        $this->addSql('CREATE TABLE population_per_elomrade (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, elomrade VARCHAR(3) NOT NULL, population INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE population_per_lan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, stockholm INTEGER DEFAULT NULL, uppsala INTEGER DEFAULT NULL, sodermanland INTEGER DEFAULT NULL, ostergotland INTEGER DEFAULT NULL, jonkoping INTEGER DEFAULT NULL, kronoberg INTEGER DEFAULT NULL, kalmar INTEGER DEFAULT NULL, gotland INTEGER DEFAULT NULL, blekinge INTEGER DEFAULT NULL, skane INTEGER DEFAULT NULL, halland INTEGER DEFAULT NULL, vastra_gotaland INTEGER DEFAULT NULL, varmland INTEGER DEFAULT NULL, orebro INTEGER DEFAULT NULL, vastmanland INTEGER DEFAULT NULL, dalarnas_lan INTEGER DEFAULT NULL, gavleborg INTEGER DEFAULT NULL, vasternorrland INTEGER DEFAULT NULL, jamtland INTEGER DEFAULT NULL, vasterbotten INTEGER DEFAULT NULL, norrbotten INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE renewable_energy_percentage (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, vim INTEGER DEFAULT NULL, el INTEGER DEFAULT NULL, transport INTEGER DEFAULT NULL, total INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE renewable_energy_twh (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, biofuels INTEGER DEFAULT NULL, hydropower INTEGER DEFAULT NULL, wind_power INTEGER DEFAULT NULL, heat_pump INTEGER DEFAULT NULL, solar_energy INTEGER DEFAULT NULL, total INTEGER DEFAULT NULL, stat_transfer_to_norway INTEGER DEFAULT NULL, renewable_energy_in_target_calculation INTEGER DEFAULT NULL, total_energy_use INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE average_annual_cost_per_person');
        $this->addSql('DROP TABLE average_consumption');
        $this->addSql('DROP TABLE consumption_per_capita');
        $this->addSql('DROP TABLE electricity_price');
        $this->addSql('DROP TABLE energy_consumption');
        $this->addSql('DROP TABLE energy_supply_gdp');
        $this->addSql('DROP TABLE lan_elomrade');
        $this->addSql('DROP TABLE library');
        $this->addSql('DROP TABLE population_per_elomrade');
        $this->addSql('DROP TABLE population_per_lan');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE renewable_energy_percentage');
        $this->addSql('DROP TABLE renewable_energy_twh');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
