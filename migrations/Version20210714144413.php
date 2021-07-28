<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714144413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creation des tables departement commune arrondissement quartier';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arrondissement (id INT AUTO_INCREMENT NOT NULL, commune_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3A3B64C4131A4F72 (commune_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E2E2D1EECCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quartier (id INT AUTO_INCREMENT NOT NULL, arrondissement_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_FEE8962D407DBC11 (arrondissement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arrondissement ADD CONSTRAINT FK_3A3B64C4131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EECCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D407DBC11 FOREIGN KEY (arrondissement_id) REFERENCES arrondissement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D407DBC11');
        $this->addSql('ALTER TABLE arrondissement DROP FOREIGN KEY FK_3A3B64C4131A4F72');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EECCF9E01E');
        $this->addSql('DROP TABLE arrondissement');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE quartier');
    }
}
