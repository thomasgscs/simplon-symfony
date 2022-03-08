<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308205122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('DROP INDEX IDX_2FB3D0EE19EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project AS SELECT id, client_id, name FROM project');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_2FB3D0EE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO project (id, client_id, name) SELECT id, client_id, name FROM __temp__project');
        $this->addSql('DROP TABLE __temp__project');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE19EB6921 ON project (client_id)');
        $this->addSql('DROP INDEX IDX_74C7CE4D166D1F9C');
        $this->addSql('DROP INDEX IDX_74C7CE4D64DD9267');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_developer AS SELECT project_id, developer_id FROM project_developer');
        $this->addSql('DROP TABLE project_developer');
        $this->addSql('CREATE TABLE project_developer (project_id INTEGER NOT NULL, developer_id INTEGER NOT NULL, PRIMARY KEY(project_id, developer_id), CONSTRAINT FK_74C7CE4D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_74C7CE4D64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO project_developer (project_id, developer_id) SELECT project_id, developer_id FROM __temp__project_developer');
        $this->addSql('DROP TABLE __temp__project_developer');
        $this->addSql('CREATE INDEX IDX_74C7CE4D166D1F9C ON project_developer (project_id)');
        $this->addSql('CREATE INDEX IDX_74C7CE4D64DD9267 ON project_developer (developer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_2FB3D0EE19EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project AS SELECT id, client_id, name FROM project');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO project (id, client_id, name) SELECT id, client_id, name FROM __temp__project');
        $this->addSql('DROP TABLE __temp__project');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE19EB6921 ON project (client_id)');
        $this->addSql('DROP INDEX IDX_74C7CE4D166D1F9C');
        $this->addSql('DROP INDEX IDX_74C7CE4D64DD9267');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_developer AS SELECT project_id, developer_id FROM project_developer');
        $this->addSql('DROP TABLE project_developer');
        $this->addSql('CREATE TABLE project_developer (project_id INTEGER NOT NULL, developer_id INTEGER NOT NULL, PRIMARY KEY(project_id, developer_id))');
        $this->addSql('INSERT INTO project_developer (project_id, developer_id) SELECT project_id, developer_id FROM __temp__project_developer');
        $this->addSql('DROP TABLE __temp__project_developer');
        $this->addSql('CREATE INDEX IDX_74C7CE4D166D1F9C ON project_developer (project_id)');
        $this->addSql('CREATE INDEX IDX_74C7CE4D64DD9267 ON project_developer (developer_id)');
    }
}
