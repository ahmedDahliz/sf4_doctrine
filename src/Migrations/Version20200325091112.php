<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200325091112 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE order_product (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46F65E9B0F FOREIGN KEY (order_product_id) REFERENCES order_product (id)');
        $this->addSql('CREATE INDEX IDX_ED896F46F65E9B0F ON order_detail (order_product_id)');
        $this->addSql('ALTER TABLE order_detail RENAME INDEX fk_ed896f464584665a TO IDX_ED896F464584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD17E8A46A');
        $this->addSql('DROP INDEX IDX_D34A04AD17E8A46A ON product');
        $this->addSql('ALTER TABLE product ADD category_id INT NOT NULL, DROP orderdetail_id');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46F65E9B0F');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP TABLE order_product');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP INDEX IDX_ED896F46F65E9B0F ON order_detail');
        $this->addSql('ALTER TABLE order_detail RENAME INDEX idx_ed896f464584665a TO FK_ED896F464584665A');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product ADD orderdetail_id INT DEFAULT NULL, DROP category_id');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD17E8A46A FOREIGN KEY (orderdetail_id) REFERENCES order_detail (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D34A04AD17E8A46A ON product (orderdetail_id)');
    }
}
