<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721160432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add touch_count column in target table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_232B318C99E6F5DF');
        $this->addSql('DROP INDEX UNIQ_232B318C53C55F64');
        $this->addSql('CREATE TEMPORARY TABLE __temp__game AS SELECT id, map_id, player_id FROM game');
        $this->addSql('DROP TABLE game');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, map_id INTEGER NOT NULL, player_id INTEGER NOT NULL, CONSTRAINT FK_232B318C53C55F64 FOREIGN KEY (map_id) REFERENCES map (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_232B318C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO game (id, map_id, player_id) SELECT id, map_id, player_id FROM __temp__game');
        $this->addSql('DROP TABLE __temp__game');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C99E6F5DF ON game (player_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C53C55F64 ON game (map_id)');
        $this->addSql('DROP INDEX UNIQ_93ADAABB158E0B66');
        $this->addSql('CREATE TEMPORARY TABLE __temp__map AS SELECT id, target_id FROM map');
        $this->addSql('DROP TABLE map');
        $this->addSql('CREATE TABLE map (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, target_id INTEGER NOT NULL, CONSTRAINT FK_93ADAABB158E0B66 FOREIGN KEY (target_id) REFERENCES target (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO map (id, target_id) SELECT id, target_id FROM __temp__map');
        $this->addSql('DROP TABLE __temp__map');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93ADAABB158E0B66 ON map (target_id)');
        $this->addSql('DROP INDEX UNIQ_98197A65DD842E46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__player AS SELECT id, position_id FROM player');
        $this->addSql('DROP TABLE player');
        $this->addSql('CREATE TABLE player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, position_id INTEGER NOT NULL, CONSTRAINT FK_98197A65DD842E46 FOREIGN KEY (position_id) REFERENCES position (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO player (id, position_id) SELECT id, position_id FROM __temp__player');
        $this->addSql('DROP TABLE __temp__player');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65DD842E46 ON player (position_id)');
        $this->addSql('DROP INDEX UNIQ_466F2FFCDD842E46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__target AS SELECT id, position_id FROM target');
        $this->addSql('DROP TABLE target');
        $this->addSql('CREATE TABLE target (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, position_id INTEGER NOT NULL, touch_count SMALLINT DEFAULT NULL, CONSTRAINT FK_466F2FFCDD842E46 FOREIGN KEY (position_id) REFERENCES position (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO target (id, position_id) SELECT id, position_id FROM __temp__target');
        $this->addSql('DROP TABLE __temp__target');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_466F2FFCDD842E46 ON target (position_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_232B318C53C55F64');
        $this->addSql('DROP INDEX UNIQ_232B318C99E6F5DF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__game AS SELECT id, map_id, player_id FROM game');
        $this->addSql('DROP TABLE game');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, map_id INTEGER NOT NULL, player_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO game (id, map_id, player_id) SELECT id, map_id, player_id FROM __temp__game');
        $this->addSql('DROP TABLE __temp__game');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C53C55F64 ON game (map_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C99E6F5DF ON game (player_id)');
        $this->addSql('DROP INDEX UNIQ_93ADAABB158E0B66');
        $this->addSql('CREATE TEMPORARY TABLE __temp__map AS SELECT id, target_id FROM map');
        $this->addSql('DROP TABLE map');
        $this->addSql('CREATE TABLE map (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, target_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO map (id, target_id) SELECT id, target_id FROM __temp__map');
        $this->addSql('DROP TABLE __temp__map');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93ADAABB158E0B66 ON map (target_id)');
        $this->addSql('DROP INDEX UNIQ_98197A65DD842E46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__player AS SELECT id, position_id FROM player');
        $this->addSql('DROP TABLE player');
        $this->addSql('CREATE TABLE player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, position_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO player (id, position_id) SELECT id, position_id FROM __temp__player');
        $this->addSql('DROP TABLE __temp__player');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65DD842E46 ON player (position_id)');
        $this->addSql('DROP INDEX UNIQ_466F2FFCDD842E46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__target AS SELECT id, position_id FROM target');
        $this->addSql('DROP TABLE target');
        $this->addSql('CREATE TABLE target (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, position_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO target (id, position_id) SELECT id, position_id FROM __temp__target');
        $this->addSql('DROP TABLE __temp__target');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_466F2FFCDD842E46 ON target (position_id)');
    }
}
