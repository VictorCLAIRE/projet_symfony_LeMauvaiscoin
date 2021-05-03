<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210428125506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP INDEX UNIQ_CB988C6FA9E29FCE, ADD INDEX IDX_CB988C6FA9E29FCE (region_annonce_id)');
        $this->addSql('ALTER TABLE annonces DROP INDEX UNIQ_CB988C6F16CC6183, ADD INDEX IDX_CB988C6F16CC6183 (categorie_annonce_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP INDEX IDX_CB988C6F16CC6183, ADD UNIQUE INDEX UNIQ_CB988C6F16CC6183 (categorie_annonce_id)');
        $this->addSql('ALTER TABLE annonces DROP INDEX IDX_CB988C6FA9E29FCE, ADD UNIQUE INDEX UNIQ_CB988C6FA9E29FCE (region_annonce_id)');
    }
}
