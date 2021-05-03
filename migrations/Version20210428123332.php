<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210428123332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, name_region VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces ADD categorie_annonce_id INT NOT NULL, ADD region_annonce_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F16CC6183 FOREIGN KEY (categorie_annonce_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FA9E29FCE FOREIGN KEY (region_annonce_id) REFERENCES regions (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB988C6F16CC6183 ON annonces (categorie_annonce_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB988C6FA9E29FCE ON annonces (region_annonce_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F16CC6183');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FA9E29FCE');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE regions');
        $this->addSql('DROP INDEX UNIQ_CB988C6F16CC6183 ON annonces');
        $this->addSql('DROP INDEX UNIQ_CB988C6FA9E29FCE ON annonces');
        $this->addSql('ALTER TABLE annonces DROP categorie_annonce_id, DROP region_annonce_id');
    }
}
