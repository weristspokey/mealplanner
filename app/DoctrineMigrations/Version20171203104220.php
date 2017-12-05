<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171203104220 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_60007FC159D8A214');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe_item AS SELECT id, recipe_id, foodId FROM recipe_item');
        $this->addSql('DROP TABLE recipe_item');
        $this->addSql('CREATE TABLE recipe_item (id INTEGER NOT NULL, recipe_id INTEGER DEFAULT NULL, foodId INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_60007FC159D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO recipe_item (id, recipe_id, foodId) SELECT id, recipe_id, foodId FROM __temp__recipe_item');
        $this->addSql('DROP TABLE __temp__recipe_item');
        $this->addSql('CREATE INDEX IDX_60007FC159D8A214 ON recipe_item (recipe_id)');
        $this->addSql('DROP INDEX UNIQ_DA88B1375E237E06');
        $this->addSql('DROP INDEX IDX_DA88B137A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe AS SELECT id, user_id, name, description, tags, image FROM recipe');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('CREATE TABLE recipe (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, tags CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:simple_array)
        , image VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_DA88B137A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO recipe (id, user_id, name, description, tags, image) SELECT id, user_id, name, description, tags, image FROM __temp__recipe');
        $this->addSql('DROP TABLE __temp__recipe');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA88B1375E237E06 ON recipe (name)');
        $this->addSql('CREATE INDEX IDX_DA88B137A76ED395 ON recipe (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_DA88B1375E237E06');
        $this->addSql('DROP INDEX IDX_DA88B137A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe AS SELECT id, user_id, name, description, tags, image FROM recipe');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('CREATE TABLE recipe (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL, tags CLOB DEFAULT NULL --(DC2Type:simple_array)
        , image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO recipe (id, user_id, name, description, tags, image) SELECT id, user_id, name, description, tags, image FROM __temp__recipe');
        $this->addSql('DROP TABLE __temp__recipe');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA88B1375E237E06 ON recipe (name)');
        $this->addSql('CREATE INDEX IDX_DA88B137A76ED395 ON recipe (user_id)');
        $this->addSql('DROP INDEX IDX_60007FC159D8A214');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe_item AS SELECT id, recipe_id, foodId FROM recipe_item');
        $this->addSql('DROP TABLE recipe_item');
        $this->addSql('CREATE TABLE recipe_item (id INTEGER NOT NULL, recipe_id INTEGER DEFAULT NULL, foodId INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO recipe_item (id, recipe_id, foodId) SELECT id, recipe_id, foodId FROM __temp__recipe_item');
        $this->addSql('DROP TABLE __temp__recipe_item');
        $this->addSql('CREATE INDEX IDX_60007FC159D8A214 ON recipe_item (recipe_id)');
    }
}
