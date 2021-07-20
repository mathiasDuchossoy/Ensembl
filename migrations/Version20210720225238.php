<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720225238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, map_id INTEGER NOT NULL, player_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C53C55F64 ON game (map_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C99E6F5DF ON game (player_id)');
        $this->addSql('CREATE TABLE map (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, target_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93ADAABB158E0B66 ON map (target_id)');
        $this->addSql('CREATE TABLE player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, position_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65DD842E46 ON player (position_id)');
        $this->addSql('CREATE TABLE position (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, x SMALLINT NOT NULL, y SMALLINT NOT NULL)');
        $this->addSql('CREATE TABLE target (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, position_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_466F2FFCDD842E46 ON target (position_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE target');
    }
}
