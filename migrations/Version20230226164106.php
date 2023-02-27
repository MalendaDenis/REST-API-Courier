<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226164106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE courier (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CF134C7CE7927C74 (email), INDEX IDX_CF134C7C64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `location` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, shipping_cost INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, courier_id INT DEFAULT NULL, order_price DOUBLE PRECISION NOT NULL, customer_name VARCHAR(255) NOT NULL, phone VARCHAR(15) NOT NULL, secret_word VARCHAR(10) NOT NULL, address VARCHAR(255) NOT NULL, status INT NOT NULL, INDEX IDX_F529939864D218E (location_id), INDEX IDX_F5299398E3D8151C (courier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE courier ADD CONSTRAINT FK_CF134C7C64D218E FOREIGN KEY (location_id) REFERENCES `location` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939864D218E FOREIGN KEY (location_id) REFERENCES `location` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398E3D8151C FOREIGN KEY (courier_id) REFERENCES courier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courier DROP FOREIGN KEY FK_CF134C7C64D218E');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939864D218E');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398E3D8151C');
        $this->addSql('DROP TABLE courier');
        $this->addSql('DROP TABLE `location`');
        $this->addSql('DROP TABLE `order`');
    }
}
