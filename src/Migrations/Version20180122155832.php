<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180122155832 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_C57767D6A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__kitchenList AS SELECT id, user_id, name FROM kitchenList');
        $this->addSql('DROP TABLE kitchenList');
        $this->addSql('CREATE TABLE kitchenList (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_C57767D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO kitchenList (id, user_id, name) SELECT id, user_id, name FROM __temp__kitchenList');
        $this->addSql('DROP TABLE __temp__kitchenList');
        $this->addSql('CREATE INDEX IDX_C57767D6A76ED395 ON kitchenList (user_id)');
        $this->addSql('DROP INDEX IDX_389B783A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag AS SELECT id, user_id, name, color FROM tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('CREATE TABLE tag (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, color VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_389B783A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tag (id, user_id, name, color) SELECT id, user_id, name, color FROM __temp__tag');
        $this->addSql('DROP TABLE __temp__tag');
        $this->addSql('CREATE INDEX IDX_389B783A76ED395 ON tag (user_id)');
        $this->addSql('DROP INDEX IDX_60007FC1BA8E87C4');
        $this->addSql('DROP INDEX IDX_60007FC159D8A214');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe_item AS SELECT id, recipe_id, food_id, value, unit FROM recipe_item');
        $this->addSql('DROP TABLE recipe_item');
        $this->addSql('CREATE TABLE recipe_item (id INTEGER NOT NULL, recipe_id INTEGER DEFAULT NULL, food_id INTEGER DEFAULT NULL, value INTEGER NOT NULL, unit VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_60007FC159D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_60007FC1BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO recipe_item (id, recipe_id, food_id, value, unit) SELECT id, recipe_id, food_id, value, unit FROM __temp__recipe_item');
        $this->addSql('DROP TABLE __temp__recipe_item');
        $this->addSql('CREATE INDEX IDX_60007FC1BA8E87C4 ON recipe_item (food_id)');
        $this->addSql('CREATE INDEX IDX_60007FC159D8A214 ON recipe_item (recipe_id)');
        $this->addSql('DROP INDEX IDX_DA88B137A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe AS SELECT id, user_id, name, description, tags, image FROM recipe');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('CREATE TABLE recipe (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, tags CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:array)
        , image VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_DA88B137A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO recipe (id, user_id, name, description, tags, image) SELECT id, user_id, name, description, tags, image FROM __temp__recipe');
        $this->addSql('DROP TABLE __temp__recipe');
        $this->addSql('CREATE INDEX IDX_DA88B137A76ED395 ON recipe (user_id)');
        $this->addSql('DROP INDEX IDX_8546B844B989588');
        $this->addSql('DROP INDEX IDX_8546B844BA8E87C4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__kitchen_list_item AS SELECT id, food_id, kitchenList_id FROM kitchen_list_item');
        $this->addSql('DROP TABLE kitchen_list_item');
        $this->addSql('CREATE TABLE kitchen_list_item (id INTEGER NOT NULL, food_id INTEGER DEFAULT NULL, kitchenList_id INTEGER DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_8546B844B989588 FOREIGN KEY (kitchenList_id) REFERENCES kitchenList (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8546B844BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO kitchen_list_item (id, food_id, kitchenList_id) SELECT id, food_id, kitchenList_id FROM __temp__kitchen_list_item');
        $this->addSql('DROP TABLE __temp__kitchen_list_item');
        $this->addSql('CREATE INDEX IDX_8546B844B989588 ON kitchen_list_item (kitchenList_id)');
        $this->addSql('CREATE INDEX IDX_8546B844BA8E87C4 ON kitchen_list_item (food_id)');
        $this->addSql('DROP INDEX IDX_4F9668F4BA8E87C4');
        $this->addSql('DROP INDEX IDX_4F9668F48BB5F188');
        $this->addSql('CREATE TEMPORARY TABLE __temp__grocerylist_item AS SELECT id, grocerylist_id, food_id FROM grocerylist_item');
        $this->addSql('DROP TABLE grocerylist_item');
        $this->addSql('CREATE TABLE grocerylist_item (id INTEGER NOT NULL, grocerylist_id INTEGER DEFAULT NULL, food_id INTEGER DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_4F9668F48BB5F188 FOREIGN KEY (grocerylist_id) REFERENCES grocerylist (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4F9668F4BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO grocerylist_item (id, grocerylist_id, food_id) SELECT id, grocerylist_id, food_id FROM __temp__grocerylist_item');
        $this->addSql('DROP TABLE __temp__grocerylist_item');
        $this->addSql('CREATE INDEX IDX_4F9668F4BA8E87C4 ON grocerylist_item (food_id)');
        $this->addSql('CREATE INDEX IDX_4F9668F48BB5F188 ON grocerylist_item (grocerylist_id)');
        $this->addSql('DROP INDEX IDX_3340E4EDA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__grocerylist AS SELECT id, user_id, name FROM grocerylist');
        $this->addSql('DROP TABLE grocerylist');
        $this->addSql('CREATE TABLE grocerylist (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_3340E4EDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO grocerylist (id, user_id, name) SELECT id, user_id, name FROM __temp__grocerylist');
        $this->addSql('DROP TABLE __temp__grocerylist');
        $this->addSql('CREATE INDEX IDX_3340E4EDA76ED395 ON grocerylist (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_3340E4EDA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__grocerylist AS SELECT id, user_id, name FROM grocerylist');
        $this->addSql('DROP TABLE grocerylist');
        $this->addSql('CREATE TABLE grocerylist (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO grocerylist (id, user_id, name) SELECT id, user_id, name FROM __temp__grocerylist');
        $this->addSql('DROP TABLE __temp__grocerylist');
        $this->addSql('CREATE INDEX IDX_3340E4EDA76ED395 ON grocerylist (user_id)');
        $this->addSql('DROP INDEX IDX_4F9668F48BB5F188');
        $this->addSql('DROP INDEX IDX_4F9668F4BA8E87C4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__grocerylist_item AS SELECT id, grocerylist_id, food_id FROM grocerylist_item');
        $this->addSql('DROP TABLE grocerylist_item');
        $this->addSql('CREATE TABLE grocerylist_item (id INTEGER NOT NULL, grocerylist_id INTEGER DEFAULT NULL, food_id INTEGER DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO grocerylist_item (id, grocerylist_id, food_id) SELECT id, grocerylist_id, food_id FROM __temp__grocerylist_item');
        $this->addSql('DROP TABLE __temp__grocerylist_item');
        $this->addSql('CREATE INDEX IDX_4F9668F48BB5F188 ON grocerylist_item (grocerylist_id)');
        $this->addSql('CREATE INDEX IDX_4F9668F4BA8E87C4 ON grocerylist_item (food_id)');
        $this->addSql('DROP INDEX IDX_C57767D6A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__kitchenList AS SELECT id, user_id, name FROM kitchenList');
        $this->addSql('DROP TABLE kitchenList');
        $this->addSql('CREATE TABLE kitchenList (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO kitchenList (id, user_id, name) SELECT id, user_id, name FROM __temp__kitchenList');
        $this->addSql('DROP TABLE __temp__kitchenList');
        $this->addSql('CREATE INDEX IDX_C57767D6A76ED395 ON kitchenList (user_id)');
        $this->addSql('DROP INDEX IDX_8546B844B989588');
        $this->addSql('DROP INDEX IDX_8546B844BA8E87C4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__kitchen_list_item AS SELECT id, food_id, kitchenList_id FROM kitchen_list_item');
        $this->addSql('DROP TABLE kitchen_list_item');
        $this->addSql('CREATE TABLE kitchen_list_item (id INTEGER NOT NULL, food_id INTEGER DEFAULT NULL, kitchenList_id INTEGER DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO kitchen_list_item (id, food_id, kitchenList_id) SELECT id, food_id, kitchenList_id FROM __temp__kitchen_list_item');
        $this->addSql('DROP TABLE __temp__kitchen_list_item');
        $this->addSql('CREATE INDEX IDX_8546B844B989588 ON kitchen_list_item (kitchenList_id)');
        $this->addSql('CREATE INDEX IDX_8546B844BA8E87C4 ON kitchen_list_item (food_id)');
        $this->addSql('DROP INDEX IDX_DA88B137A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe AS SELECT id, user_id, name, description, tags, image FROM recipe');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('CREATE TABLE recipe (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL, tags CLOB DEFAULT NULL --(DC2Type:array)
        , image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO recipe (id, user_id, name, description, tags, image) SELECT id, user_id, name, description, tags, image FROM __temp__recipe');
        $this->addSql('DROP TABLE __temp__recipe');
        $this->addSql('CREATE INDEX IDX_DA88B137A76ED395 ON recipe (user_id)');
        $this->addSql('DROP INDEX IDX_60007FC159D8A214');
        $this->addSql('DROP INDEX IDX_60007FC1BA8E87C4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe_item AS SELECT id, recipe_id, food_id, value, unit FROM recipe_item');
        $this->addSql('DROP TABLE recipe_item');
        $this->addSql('CREATE TABLE recipe_item (id INTEGER NOT NULL, recipe_id INTEGER DEFAULT NULL, food_id INTEGER DEFAULT NULL, value INTEGER NOT NULL, unit VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO recipe_item (id, recipe_id, food_id, value, unit) SELECT id, recipe_id, food_id, value, unit FROM __temp__recipe_item');
        $this->addSql('DROP TABLE __temp__recipe_item');
        $this->addSql('CREATE INDEX IDX_60007FC159D8A214 ON recipe_item (recipe_id)');
        $this->addSql('CREATE INDEX IDX_60007FC1BA8E87C4 ON recipe_item (food_id)');
        $this->addSql('DROP INDEX IDX_389B783A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag AS SELECT id, user_id, name, color FROM tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('CREATE TABLE tag (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO tag (id, user_id, name, color) SELECT id, user_id, name, color FROM __temp__tag');
        $this->addSql('DROP TABLE __temp__tag');
        $this->addSql('CREATE INDEX IDX_389B783A76ED395 ON tag (user_id)');
    }
}
