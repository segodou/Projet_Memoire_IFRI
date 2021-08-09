<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809002816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des tables hopitaux, supermarkets, restaurants et schools';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hopitaux (id INT AUTO_INCREMENT NOT NULL, title_h VARCHAR(255) NOT NULL, distance_h INT NOT NULL, adresse_h VARCHAR(255) NOT NULL, description_h LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurants (id INT AUTO_INCREMENT NOT NULL, title_r VARCHAR(255) NOT NULL, distance_r INT NOT NULL, adresse_r VARCHAR(255) NOT NULL, description_r LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schools (id INT AUTO_INCREMENT NOT NULL, title_s VARCHAR(255) NOT NULL, adresse_s VARCHAR(255) NOT NULL, distance_s INT NOT NULL, description_s LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE superMarkets (id INT AUTO_INCREMENT NOT NULL, title_sm VARCHAR(255) NOT NULL, distance_sm INT NOT NULL, adresse_sm VARCHAR(255) NOT NULL, description_sm LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces ADD hopital_id INT NOT NULL, ADD school_id INT NOT NULL, ADD super_market_id INT NOT NULL, ADD restaurant_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FCC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopitaux (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FC32A47EE FOREIGN KEY (school_id) REFERENCES schools (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FCE4C14E8 FOREIGN KEY (super_market_id) REFERENCES superMarkets (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('CREATE INDEX IDX_CB988C6FCC0FBF92 ON annonces (hopital_id)');
        $this->addSql('CREATE INDEX IDX_CB988C6FC32A47EE ON annonces (school_id)');
        $this->addSql('CREATE INDEX IDX_CB988C6FCE4C14E8 ON annonces (super_market_id)');
        $this->addSql('CREATE INDEX IDX_CB988C6FB1E7706E ON annonces (restaurant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FCC0FBF92');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FB1E7706E');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FC32A47EE');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FCE4C14E8');
        $this->addSql('DROP TABLE hopitaux');
        $this->addSql('DROP TABLE restaurants');
        $this->addSql('DROP TABLE schools');
        $this->addSql('DROP TABLE superMarkets');
        $this->addSql('DROP INDEX IDX_CB988C6FCC0FBF92 ON annonces');
        $this->addSql('DROP INDEX IDX_CB988C6FC32A47EE ON annonces');
        $this->addSql('DROP INDEX IDX_CB988C6FCE4C14E8 ON annonces');
        $this->addSql('DROP INDEX IDX_CB988C6FB1E7706E ON annonces');
        $this->addSql('ALTER TABLE annonces DROP hopital_id, DROP school_id, DROP super_market_id, DROP restaurant_id');
    }
}
