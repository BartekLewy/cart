<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328202711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE cart_items
                    CHANGE price_price total_price double DEFAULT 0 NOT NULL,
                    CHANGE price_vat_rate vat double DEFAULT 0 NOT NULL,
                    ADD COLUMN total_price_gross double DEFAULT 0 NOT NULL'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE cart_items
                    CHANGE total_price price_price DOUBLE DEFAULT 0 NOT NULL,
                    CHANGE vat price_vat_rate DOUBLE DEFAULT 0 NOT NULL,
                    DROP COLUMN total_price_gross;'
        );
    }
}
