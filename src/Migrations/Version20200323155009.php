<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200323155009 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `order`');
        $this->addSql('ALTER TABLE order_detail ADD product_id INT DEFAULT NULL, ADD order_product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F464584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46F65E9B0F FOREIGN KEY (order_product_id) REFERENCES order_product (id)');
        $this->addSql('CREATE INDEX IDX_ED896F464584665A ON order_detail (product_id)');
        $this->addSql('CREATE INDEX IDX_ED896F46F65E9B0F ON order_detail (order_product_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD17E8A46A');
        $this->addSql('DROP INDEX IDX_D34A04AD17E8A46A ON product');
        $this->addSql('ALTER TABLE product DROP orderdetail_id');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE664577843');
        $this->addSql('DROP INDEX IDX_2530ADE664577843 ON order_product');
        $this->addSql('ALTER TABLE order_product DROP order_detail_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, order_detail_id INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_F529939864577843 (order_detail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939864577843 FOREIGN KEY (order_detail_id) REFERENCES order_detail (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F464584665A');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46F65E9B0F');
        $this->addSql('DROP INDEX IDX_ED896F464584665A ON order_detail');
        $this->addSql('DROP INDEX IDX_ED896F46F65E9B0F ON order_detail');
        $this->addSql('ALTER TABLE order_detail DROP product_id, DROP order_product_id');
        $this->addSql('ALTER TABLE order_product ADD order_detail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE664577843 FOREIGN KEY (order_detail_id) REFERENCES order_detail (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2530ADE664577843 ON order_product (order_detail_id)');
        $this->addSql('ALTER TABLE product ADD orderdetail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD17E8A46A FOREIGN KEY (orderdetail_id) REFERENCES order_detail (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D34A04AD17E8A46A ON product (orderdetail_id)');
    }
}
