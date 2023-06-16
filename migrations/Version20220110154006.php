<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110154006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces (id INT AUTO_INCREMENT NOT NULL, quartier_id INT NOT NULL, user_id INT NOT NULL, market_id INT NOT NULL, hopital_id INT NOT NULL, school_id INT NOT NULL, super_market_id INT NOT NULL, restaurant_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price BIGINT NOT NULL, surface INT NOT NULL, rooms INT NOT NULL, bedrooms INT NOT NULL, status_annonce TINYINT(1) DEFAULT \'0\' NOT NULL, type INT NOT NULL, location VARCHAR(255) NOT NULL, sold TINYINT(1) DEFAULT \'0\' NOT NULL, approved TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CB988C6FDF1E57AB (quartier_id), INDEX IDX_CB988C6FA76ED395 (user_id), INDEX IDX_CB988C6F622F3F37 (market_id), INDEX IDX_CB988C6FCC0FBF92 (hopital_id), INDEX IDX_CB988C6FC32A47EE (school_id), INDEX IDX_CB988C6FCE4C14E8 (super_market_id), INDEX IDX_CB988C6FB1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE arrondissement (id INT AUTO_INCREMENT NOT NULL, commune_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3A3B64C4131A4F72 (commune_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E2E2D1EECCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hopitaux (id INT AUTO_INCREMENT NOT NULL, title_h VARCHAR(255) NOT NULL, adresse_h VARCHAR(255) NOT NULL, description_h LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, annonces_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A4C2885D7 (annonces_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE markets (id INT AUTO_INCREMENT NOT NULL, title_m VARCHAR(255) NOT NULL, adresse_m VARCHAR(255) NOT NULL, description_m LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quartier (id INT AUTO_INCREMENT NOT NULL, arrondissement_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_FEE8962D407DBC11 (arrondissement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_requests (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_16646B41A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurants (id INT AUTO_INCREMENT NOT NULL, title_r VARCHAR(255) NOT NULL, adresse_r VARCHAR(255) NOT NULL, description_r LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schools (id INT AUTO_INCREMENT NOT NULL, title_s VARCHAR(255) NOT NULL, adresse_s VARCHAR(255) NOT NULL, description_s LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE superMarkets (id INT AUTO_INCREMENT NOT NULL, title_sm VARCHAR(255) NOT NULL, adresse_sm VARCHAR(255) NOT NULL, description_sm LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, utilisateur VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, status_delete TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FDF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F622F3F37 FOREIGN KEY (market_id) REFERENCES markets (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FCC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopitaux (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FC32A47EE FOREIGN KEY (school_id) REFERENCES schools (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FCE4C14E8 FOREIGN KEY (super_market_id) REFERENCES superMarkets (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C4131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EECCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A4C2885D7 FOREIGN KEY (annonces_id) REFERENCES annonces (id)');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES arrondissement (id)');
        $this->addSql('ALTER TABLE reset_password_requests ADD CONSTRAINT FK_16646B41A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A4C2885D7');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D407DBC11');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C4131A4F72');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EECCF9E01E');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FCC0FBF92');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F622F3F37');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FDF1E57AB');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FB1E7706E');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FC32A47EE');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FCE4C14E8');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FA76ED395');
        $this->addSql('ALTER TABLE reset_password_requests DROP FOREIGN KEY FK_16646B41A76ED395');
        $this->addSql('DROP TABLE annonces');
        $this->addSql('DROP TABLE arrondissement');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE hopitaux');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE markets');
        $this->addSql('DROP TABLE quartier');
        $this->addSql('DROP TABLE reset_password_requests');
        $this->addSql('DROP TABLE restaurants');
        $this->addSql('DROP TABLE schools');
        $this->addSql('DROP TABLE superMarkets');
        $this->addSql('DROP TABLE users');
    }
}
