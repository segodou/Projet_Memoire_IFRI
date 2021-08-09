<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210808234424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'création de la table markets';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE markets (id INT AUTO_INCREMENT NOT NULL, title_m VARCHAR(255) NOT NULL, distance_m INT NOT NULL, adresse_m VARCHAR(255) NOT NULL, description_m LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces ADD market_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F622F3F37 FOREIGN KEY (market_id) REFERENCES markets (id)');
        $this->addSql('CREATE INDEX IDX_CB988C6F622F3F37 ON annonces (market_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F622F3F37');
        $this->addSql('DROP TABLE markets');
        $this->addSql('DROP INDEX IDX_CB988C6F622F3F37 ON annonces');
        $this->addSql('ALTER TABLE annonces DROP market_id');
    }
}
