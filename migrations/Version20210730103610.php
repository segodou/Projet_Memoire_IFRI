<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730103610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces (id INT AUTO_INCREMENT NOT NULL, quartier_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price BIGINT NOT NULL, surface INT NOT NULL, rooms INT NOT NULL, bedrooms INT NOT NULL, status_annonce TINYINT(1) DEFAULT \'0\' NOT NULL, type INT NOT NULL, location VARCHAR(255) NOT NULL, sold TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CB988C6FDF1E57AB (quartier_id), INDEX IDX_CB988C6FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE arrondissement (id INT AUTO_INCREMENT NOT NULL, commune_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3A3B64C4131A4F72 (commune_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E2E2D1EECCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, annonces_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A4C2885D7 (annonces_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quartier (id INT AUTO_INCREMENT NOT NULL, arrondissement_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_FEE8962D407DBC11 (arrondissement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FDF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C4131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EECCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A4C2885D7 FOREIGN KEY (annonces_id) REFERENCES annonces (id)');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES arrondissement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A4C2885D7');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D407DBC11');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C4131A4F72');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EECCF9E01E');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FDF1E57AB');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FA76ED395');
        $this->addSql('DROP TABLE annonces');
        $this->addSql('DROP TABLE arrondissement');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE quartier');
        $this->addSql('DROP TABLE users');
    }
}
