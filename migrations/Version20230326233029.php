<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326233029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_items DROP FOREIGN KEY FK_BEF484451AD5CDBF');
        $this->addSql('DROP INDEX IDX_BEF484451AD5CDBF ON cart_items');
        $this->addSql('DROP INDEX `primary` ON cart_items');
        $this->addSql('ALTER TABLE cart_items CHANGE cart_id cart_id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE cart_items ADD PRIMARY KEY (id, cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON cart_items');
        $this->addSql('ALTER TABLE cart_items CHANGE cart_id cart_id CHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_items ADD CONSTRAINT FK_BEF484451AD5CDBF FOREIGN KEY (cart_id) REFERENCES carts (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BEF484451AD5CDBF ON cart_items (cart_id)');
        $this->addSql('ALTER TABLE cart_items ADD PRIMARY KEY (id)');
    }
}
