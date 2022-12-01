<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221201110018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, firstname, lastname, preferred_channel, password, roles FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, preferred_channel VARCHAR(20) DEFAULT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:simple_array)
        )');
        $this->addSql('INSERT INTO user (id, email, firstname, lastname, preferred_channel, password, roles) SELECT id, email, firstname, lastname, preferred_channel, password, roles FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, firstname, lastname, preferred_channel, password, roles FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, preferred_channel VARCHAR(20) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, firstname, lastname, preferred_channel, password, roles) SELECT id, email, firstname, lastname, preferred_channel, password, roles FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
