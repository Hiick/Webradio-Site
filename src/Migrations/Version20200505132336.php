<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200505132336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE channels (id INT AUTO_INCREMENT NOT NULL, avatar VARCHAR(255) NOT NULL, nom_chaine VARCHAR(255) NOT NULL, proprietaire VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_signals (id INT AUTO_INCREMENT NOT NULL, flux_audio VARCHAR(255) NOT NULL, date_debut_stream VARCHAR(255) NOT NULL, date_heure_signalement VARCHAR(255) NOT NULL, motif VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE radio (id INT AUTO_INCREMENT NOT NULL, avatar VARCHAR(255) NOT NULL, name_radio VARCHAR(255) NOT NULL, url_radio VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signalements (id INT AUTO_INCREMENT NOT NULL, avatar VARCHAR(255) NOT NULL, nom_chaine VARCHAR(255) NOT NULL, nombre_signal INT NOT NULL, list_signal VARCHAR(255) NOT NULL, management VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, avatar VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, channels VARCHAR(255) DEFAULT NULL, roles VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE channels');
        $this->addSql('DROP TABLE list_signals');
        $this->addSql('DROP TABLE radio');
        $this->addSql('DROP TABLE signalements');
        $this->addSql('DROP TABLE user');
    }
}
