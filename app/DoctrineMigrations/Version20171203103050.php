<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171203103050 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE recipe_item (id INTEGER NOT NULL, recipe_id INTEGER DEFAULT NULL, foodId INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_60007FC159D8A214 ON recipe_item (recipe_id)');
        $this->addSql('DROP INDEX UNIQ_DA88B1375E237E06');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe AS SELECT id, user_id, name, description, tags, image FROM recipe');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('CREATE TABLE recipe (id INTEGER NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, tags CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:simple_array)
        , image VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO recipe (id, user_id, name, description, tags, image) SELECT id, user_id, name, description, tags, image FROM __temp__recipe');
        $this->addSql('DROP TABLE __temp__recipe');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA88B1375E237E06 ON recipe (name)');
        $this->addSql('DROP INDEX UNIQ_D43829F75E237E06');
        $this->addSql('CREATE TEMPORARY TABLE __temp__food AS SELECT id, name, is_vegetarian, is_vegan FROM food');
        $this->addSql('DROP TABLE food');
        $this->addSql('CREATE TABLE food (id INTEGER NOT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, is_vegetarian BOOLEAN NOT NULL, is_vegan BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO food (id, name, is_vegetarian, is_vegan) SELECT id, name, is_vegetarian, is_vegan FROM __temp__food');
        $this->addSql('DROP TABLE __temp__food');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D43829F75E237E06 ON food (name)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE recipe_item');
        $this->addSql('ALTER TABLE food ADD COLUMN in_stock BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE recipe ADD COLUMN ingredients CLOB NOT NULL COLLATE BINARY');
        $this->addSql('ALTER TABLE recipe ADD COLUMN in_stock BOOLEAN NOT NULL');
    }
}
