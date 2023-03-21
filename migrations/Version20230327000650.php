<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327000650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON cart_items');
        $this->addSql('ALTER TABLE cart_items ADD product_id CHAR(36) DEFAULT NULL, CHANGE cart_id cart_id CHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_items ADD CONSTRAINT FK_BEF484454584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE cart_items ADD CONSTRAINT FK_BEF484451AD5CDBF FOREIGN KEY (cart_id) REFERENCES carts (id)');
        $this->addSql('CREATE INDEX IDX_BEF484454584665A ON cart_items (product_id)');
        $this->addSql('CREATE INDEX IDX_BEF484451AD5CDBF ON cart_items (cart_id)');
        $this->addSql('ALTER TABLE cart_items ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_items DROP FOREIGN KEY FK_BEF484454584665A');
        $this->addSql('ALTER TABLE cart_items DROP FOREIGN KEY FK_BEF484451AD5CDBF');
        $this->addSql('DROP INDEX IDX_BEF484454584665A ON cart_items');
        $this->addSql('DROP INDEX IDX_BEF484451AD5CDBF ON cart_items');
        $this->addSql('DROP INDEX `PRIMARY` ON cart_items');
        $this->addSql('ALTER TABLE cart_items DROP product_id, CHANGE cart_id cart_id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE cart_items ADD PRIMARY KEY (id, cart_id)');
    }
}
