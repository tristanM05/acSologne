<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200415150427 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE actu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, description VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, tarifs VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE machines (id INT AUTO_INCREMENT NOT NULL, categories_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, immatriculation VARCHAR(255) DEFAULT NULL, moteur VARCHAR(255) DEFAULT NULL, p_moteur VARCHAR(255) DEFAULT NULL, envergure DOUBLE PRECISION DEFAULT NULL, nb_place INT DEFAULT NULL, vitesse INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_F1CE8DEDA21214B7 (categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, actu_id INT DEFAULT NULL, machines_id INT DEFAULT NULL, album_id INT DEFAULT NULL, src VARCHAR(255) NOT NULL, INDEX IDX_876E0D9F77EEF58 (actu_id), INDEX IDX_876E0D9358A8F83 (machines_id), INDEX IDX_876E0D91137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, mdp_hash VARCHAR(100) NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE machines ADD CONSTRAINT FK_F1CE8DEDA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9F77EEF58 FOREIGN KEY (actu_id) REFERENCES actu (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9358A8F83 FOREIGN KEY (machines_id) REFERENCES machines (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D91137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9F77EEF58');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D91137ABCF');
        $this->addSql('ALTER TABLE machines DROP FOREIGN KEY FK_F1CE8DEDA21214B7');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9358A8F83');
        $this->addSql('DROP TABLE actu');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE machines');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE user');
    }
}
