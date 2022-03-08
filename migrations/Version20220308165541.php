<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308165541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, website_url VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE developer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE19EB6921 ON project (client_id)');
        $this->addSql('CREATE TABLE project_developer (project_id INTEGER NOT NULL, developer_id INTEGER NOT NULL, PRIMARY KEY(project_id, developer_id))');
        $this->addSql('CREATE INDEX IDX_74C7CE4D166D1F9C ON project_developer (project_id)');
        $this->addSql('CREATE INDEX IDX_74C7CE4D64DD9267 ON project_developer (developer_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_developer');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
