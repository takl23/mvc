<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240805195903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE TABLE renewable_energy_twh (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, biofuels INTEGER DEFAULT NULL, hydropower INTEGER DEFAULT NULL, wind_power INTEGER DEFAULT NULL, heat_pump INTEGER DEFAULT NULL, solar_energy INTEGER DEFAULT NULL, total INTEGER DEFAULT NULL, stat_transfer_to_norway INTEGER DEFAULT NULL, reneweble_energy_in_target_calculation INTEGER DEFAULT NULL, total_energy_use INTEGER DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // Uncomment or modify the following line if the table does not exist
    // $this->addSql('DROP TABLE renewable_energy_twh');
    }
}
