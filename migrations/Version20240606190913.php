<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240606190913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__library AS SELECT id, book, isbn, author, cover FROM library');
        $this->addSql('DROP TABLE library');
        $this->addSql('CREATE TABLE library (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(13) NOT NULL, author VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO library (id, title, isbn, author, cover) SELECT id, book, isbn, author, cover FROM __temp__library');
        $this->addSql('DROP TABLE __temp__library');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A18098BCCC1CF4E6 ON library (isbn)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__library AS SELECT id, title, isbn, author, cover FROM library');
        $this->addSql('DROP TABLE library');
        $this->addSql('CREATE TABLE library (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book VARCHAR(255) NOT NULL, isbn INTEGER NOT NULL, author VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO library (id, book, isbn, author, cover) SELECT id, title, isbn, author, cover FROM __temp__library');
        $this->addSql('DROP TABLE __temp__library');
    }
}
