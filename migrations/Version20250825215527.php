<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250825215527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add indexes in "product" for "sku" and "price" ';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE id id CHAR(36) NOT NULL');
        $this->addSql('CREATE INDEX IDX_product_sku ON product (sku)');
        $this->addSql('CREATE INDEX IDX_product_price ON product (price)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_product_sku ON product');
        $this->addSql('DROP INDEX IDX_product_price ON product');
    }
}
