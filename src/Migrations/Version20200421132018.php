<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421132018 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE annonce_cat (id INT AUTO_INCREMENT NOT NULL, annonce_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_5ED313C98805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce_cat ADD CONSTRAINT FK_5ED313C98805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE album CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories CHANGE tarifs tarifs VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE formation CHANGE categories_id categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE machines CHANGE categories_id categories_id INT DEFAULT NULL, CHANGE immatriculation immatriculation VARCHAR(255) DEFAULT NULL, CHANGE moteur moteur VARCHAR(255) DEFAULT NULL, CHANGE p_moteur p_moteur VARCHAR(255) DEFAULT NULL, CHANGE envergure envergure DOUBLE PRECISION DEFAULT NULL, CHANGE nb_place nb_place INT DEFAULT NULL, CHANGE vitesse vitesse INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photos CHANGE actu_id actu_id INT DEFAULT NULL, CHANGE machines_id machines_id INT DEFAULT NULL, CHANGE album_id album_id INT DEFAULT NULL, CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE annonce_id annonce_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE annonce_cat');
        $this->addSql('ALTER TABLE album CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE annonce CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories CHANGE tarifs tarifs VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE formation CHANGE categories_id categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE machines CHANGE categories_id categories_id INT DEFAULT NULL, CHANGE immatriculation immatriculation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE moteur moteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_moteur p_moteur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE envergure envergure DOUBLE PRECISION DEFAULT \'NULL\', CHANGE nb_place nb_place INT DEFAULT NULL, CHANGE vitesse vitesse INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photos CHANGE actu_id actu_id INT DEFAULT NULL, CHANGE machines_id machines_id INT DEFAULT NULL, CHANGE album_id album_id INT DEFAULT NULL, CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE annonce_id annonce_id INT DEFAULT NULL');
    }
}
