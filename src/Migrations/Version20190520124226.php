<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190520124226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE6C416F85B');
        $this->addSql('CREATE TABLE the_order (id INT AUTO_INCREMENT NOT NULL, order_at DATETIME NOT NULL, firstname VARCHAR(30) NOT NULL, name VARCHAR(30) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE6C416F85B');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE6C416F85B FOREIGN KEY (the_order_id) REFERENCES the_order (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE6C416F85B');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, order_at DATETIME NOT NULL, firstname VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, phone VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE the_order');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE6C416F85B');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE6C416F85B FOREIGN KEY (the_order_id) REFERENCES `order` (id)');
    }
}
