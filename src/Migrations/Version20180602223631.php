<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180602223631 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE food');
        $this->addSql('DROP INDEX IDX_C57767D6A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__kitchenList AS SELECT id, user_id, name FROM kitchenList');
        $this->addSql('DROP TABLE kitchenList');
        $this->addSql('CREATE TABLE kitchenList (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_C57767D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO kitchenList (id, user_id, name) SELECT id, user_id, name FROM __temp__kitchenList');
        $this->addSql('DROP TABLE __temp__kitchenList');
        $this->addSql('CREATE INDEX IDX_C57767D6A76ED395 ON kitchenList (user_id)');
        $this->addSql('DROP INDEX IDX_389B7839D86650F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag AS SELECT id, user_id_id, name, color FROM tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('CREATE TABLE tag (id INTEGER NOT NULL, user_id_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, color VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_389B7839D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tag (id, user_id_id, name, color) SELECT id, user_id_id, name, color FROM __temp__tag');
        $this->addSql('DROP TABLE __temp__tag');
        $this->addSql('CREATE INDEX IDX_389B7839D86650F ON tag (user_id_id)');
        $this->addSql('DROP INDEX IDX_60007FC159D8A214');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe_item AS SELECT id, recipe_id, name, value, unit FROM recipe_item');
        $this->addSql('DROP TABLE recipe_item');
        $this->addSql('CREATE TABLE recipe_item (id INTEGER NOT NULL, recipe_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, value INTEGER DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_60007FC159D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO recipe_item (id, recipe_id, name, value, unit) SELECT id, recipe_id, name, value, unit FROM __temp__recipe_item');
        $this->addSql('DROP TABLE __temp__recipe_item');
        $this->addSql('CREATE INDEX IDX_60007FC159D8A214 ON recipe_item (recipe_id)');
        $this->addSql('DROP INDEX IDX_DA88B1379D86650F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe AS SELECT id, user_id_id, name, description, image, tags FROM recipe');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('CREATE TABLE recipe (id INTEGER NOT NULL, user_id_id INTEGER DEFAULT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, tags CLOB DEFAULT NULL --(DC2Type:simple_array)
        , PRIMARY KEY(id), CONSTRAINT FK_DA88B1379D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO recipe (id, user_id_id, name, description, image, tags) SELECT id, user_id_id, name, description, image, tags FROM __temp__recipe');
        $this->addSql('DROP TABLE __temp__recipe');
        $this->addSql('CREATE INDEX IDX_DA88B1379D86650F ON recipe (user_id_id)');
        $this->addSql('DROP INDEX IDX_401FB7FE59D8A214');
        $this->addSql('DROP INDEX IDX_401FB7FEA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__mealplan_item AS SELECT id, recipe_id, user_id, category, mealplanId, name FROM mealplan_item');
        $this->addSql('DROP TABLE mealplan_item');
        $this->addSql('CREATE TABLE mealplan_item (id INTEGER NOT NULL, recipe_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, category VARCHAR(255) NOT NULL COLLATE BINARY, mealplanId DATE NOT NULL, name VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_401FB7FEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_401FB7FE59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO mealplan_item (id, recipe_id, user_id, category, mealplanId, name) SELECT id, recipe_id, user_id, category, mealplanId, name FROM __temp__mealplan_item');
        $this->addSql('DROP TABLE __temp__mealplan_item');
        $this->addSql('CREATE INDEX IDX_401FB7FE59D8A214 ON mealplan_item (recipe_id)');
        $this->addSql('CREATE INDEX IDX_401FB7FEA76ED395 ON mealplan_item (user_id)');
        $this->addSql('DROP INDEX IDX_7AFE68CEB989588');
        $this->addSql('CREATE TEMPORARY TABLE __temp__kitchenListItem AS SELECT id, kitchenList_id, name FROM kitchenListItem');
        $this->addSql('DROP TABLE kitchenListItem');
        $this->addSql('CREATE TABLE kitchenListItem (id INTEGER NOT NULL, kitchenList_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_7AFE68CEB989588 FOREIGN KEY (kitchenList_id) REFERENCES kitchenList (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO kitchenListItem (id, kitchenList_id, name) SELECT id, kitchenList_id, name FROM __temp__kitchenListItem');
        $this->addSql('DROP TABLE __temp__kitchenListItem');
        $this->addSql('CREATE INDEX IDX_7AFE68CEB989588 ON kitchenListItem (kitchenList_id)');
        $this->addSql('DROP INDEX IDX_4F9668F48BB5F188');
        $this->addSql('CREATE TEMPORARY TABLE __temp__grocerylist_item AS SELECT id, grocerylist_id, name FROM grocerylist_item');
        $this->addSql('DROP TABLE grocerylist_item');
        $this->addSql('CREATE TABLE grocerylist_item (id INTEGER NOT NULL, grocerylist_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_4F9668F48BB5F188 FOREIGN KEY (grocerylist_id) REFERENCES grocerylist (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO grocerylist_item (id, grocerylist_id, name) SELECT id, grocerylist_id, name FROM __temp__grocerylist_item');
        $this->addSql('DROP TABLE __temp__grocerylist_item');
        $this->addSql('CREATE INDEX IDX_4F9668F48BB5F188 ON grocerylist_item (grocerylist_id)');
        $this->addSql('DROP INDEX IDX_3340E4EDA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__grocerylist AS SELECT id, user_id, name FROM grocerylist');
        $this->addSql('DROP TABLE grocerylist');
        $this->addSql('CREATE TABLE grocerylist (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_3340E4EDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO grocerylist (id, user_id, name) SELECT id, user_id, name FROM __temp__grocerylist');
        $this->addSql('DROP TABLE __temp__grocerylist');
        $this->addSql('CREATE INDEX IDX_3340E4EDA76ED395 ON grocerylist (user_id)');
        $this->addSql('DROP INDEX IDX_9436CB93A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__mealplan AS SELECT id, user_id, date FROM mealplan');
        $this->addSql('DROP TABLE mealplan');
        $this->addSql('CREATE TABLE mealplan (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, date DATE NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_9436CB93A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO mealplan (id, user_id, date) SELECT id, user_id, date FROM __temp__mealplan');
        $this->addSql('DROP TABLE __temp__mealplan');
        $this->addSql('CREATE INDEX IDX_9436CB93A76ED395 ON mealplan (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE food (id INTEGER NOT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, is_vegetarian BOOLEAN NOT NULL, is_vegan BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D43829F75E237E06 ON food (name)');
        $this->addSql('DROP INDEX IDX_3340E4EDA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__grocerylist AS SELECT id, user_id, name FROM grocerylist');
        $this->addSql('DROP TABLE grocerylist');
        $this->addSql('CREATE TABLE grocerylist (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO grocerylist (id, user_id, name) SELECT id, user_id, name FROM __temp__grocerylist');
        $this->addSql('DROP TABLE __temp__grocerylist');
        $this->addSql('CREATE INDEX IDX_3340E4EDA76ED395 ON grocerylist (user_id)');
        $this->addSql('DROP INDEX IDX_4F9668F48BB5F188');
        $this->addSql('CREATE TEMPORARY TABLE __temp__grocerylist_item AS SELECT id, grocerylist_id, name FROM grocerylist_item');
        $this->addSql('DROP TABLE grocerylist_item');
        $this->addSql('CREATE TABLE grocerylist_item (id INTEGER NOT NULL, grocerylist_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO grocerylist_item (id, grocerylist_id, name) SELECT id, grocerylist_id, name FROM __temp__grocerylist_item');
        $this->addSql('DROP TABLE __temp__grocerylist_item');
        $this->addSql('CREATE INDEX IDX_4F9668F48BB5F188 ON grocerylist_item (grocerylist_id)');
        $this->addSql('DROP INDEX IDX_C57767D6A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__kitchenList AS SELECT id, user_id, name FROM kitchenList');
        $this->addSql('DROP TABLE kitchenList');
        $this->addSql('CREATE TABLE kitchenList (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO kitchenList (id, user_id, name) SELECT id, user_id, name FROM __temp__kitchenList');
        $this->addSql('DROP TABLE __temp__kitchenList');
        $this->addSql('CREATE INDEX IDX_C57767D6A76ED395 ON kitchenList (user_id)');
        $this->addSql('DROP INDEX IDX_7AFE68CEB989588');
        $this->addSql('CREATE TEMPORARY TABLE __temp__kitchenListItem AS SELECT id, name, kitchenList_id FROM kitchenListItem');
        $this->addSql('DROP TABLE kitchenListItem');
        $this->addSql('CREATE TABLE kitchenListItem (id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, kitchenList_id INTEGER DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO kitchenListItem (id, name, kitchenList_id) SELECT id, name, kitchenList_id FROM __temp__kitchenListItem');
        $this->addSql('DROP TABLE __temp__kitchenListItem');
        $this->addSql('CREATE INDEX IDX_7AFE68CEB989588 ON kitchenListItem (kitchenList_id)');
        $this->addSql('DROP INDEX IDX_9436CB93A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__mealplan AS SELECT id, user_id, date FROM mealplan');
        $this->addSql('DROP TABLE mealplan');
        $this->addSql('CREATE TABLE mealplan (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO mealplan (id, user_id, date) SELECT id, user_id, date FROM __temp__mealplan');
        $this->addSql('DROP TABLE __temp__mealplan');
        $this->addSql('CREATE INDEX IDX_9436CB93A76ED395 ON mealplan (user_id)');
        $this->addSql('DROP INDEX IDX_401FB7FEA76ED395');
        $this->addSql('DROP INDEX IDX_401FB7FE59D8A214');
        $this->addSql('CREATE TEMPORARY TABLE __temp__mealplan_item AS SELECT id, user_id, recipe_id, mealplanId, name, category FROM mealplan_item');
        $this->addSql('DROP TABLE mealplan_item');
        $this->addSql('CREATE TABLE mealplan_item (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, recipe_id INTEGER DEFAULT NULL, mealplanId DATE NOT NULL, name VARCHAR(255) DEFAULT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO mealplan_item (id, user_id, recipe_id, mealplanId, name, category) SELECT id, user_id, recipe_id, mealplanId, name, category FROM __temp__mealplan_item');
        $this->addSql('DROP TABLE __temp__mealplan_item');
        $this->addSql('CREATE INDEX IDX_401FB7FEA76ED395 ON mealplan_item (user_id)');
        $this->addSql('CREATE INDEX IDX_401FB7FE59D8A214 ON mealplan_item (recipe_id)');
        $this->addSql('DROP INDEX IDX_DA88B1379D86650F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe AS SELECT id, user_id_id, name, description, tags, image FROM recipe');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('CREATE TABLE recipe (id INTEGER NOT NULL, user_id_id INTEGER DEFAULT NULL, name VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, tags CLOB DEFAULT \'NULL --(DC2Type:simple_array)\' COLLATE BINARY --(DC2Type:simple_array)
        , PRIMARY KEY(id))');
        $this->addSql('INSERT INTO recipe (id, user_id_id, name, description, tags, image) SELECT id, user_id_id, name, description, tags, image FROM __temp__recipe');
        $this->addSql('DROP TABLE __temp__recipe');
        $this->addSql('CREATE INDEX IDX_DA88B1379D86650F ON recipe (user_id_id)');
        $this->addSql('DROP INDEX IDX_60007FC159D8A214');
        $this->addSql('CREATE TEMPORARY TABLE __temp__recipe_item AS SELECT id, recipe_id, name, value, unit FROM recipe_item');
        $this->addSql('DROP TABLE recipe_item');
        $this->addSql('CREATE TABLE recipe_item (id INTEGER NOT NULL, recipe_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, value INTEGER DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO recipe_item (id, recipe_id, name, value, unit) SELECT id, recipe_id, name, value, unit FROM __temp__recipe_item');
        $this->addSql('DROP TABLE __temp__recipe_item');
        $this->addSql('CREATE INDEX IDX_60007FC159D8A214 ON recipe_item (recipe_id)');
        $this->addSql('DROP INDEX IDX_389B7839D86650F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag AS SELECT id, user_id_id, name, color FROM tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('CREATE TABLE tag (id INTEGER NOT NULL, user_id_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO tag (id, user_id_id, name, color) SELECT id, user_id_id, name, color FROM __temp__tag');
        $this->addSql('DROP TABLE __temp__tag');
        $this->addSql('CREATE INDEX IDX_389B7839D86650F ON tag (user_id_id)');
    }
}
