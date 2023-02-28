<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Courier;
use App\Repository\LocationsRepository;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227192319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO b_pay.location (name, shipping_cost) VALUES (Chisinau, 60)');
        $this->addSql('INSERT INTO b_pay.location (name, shipping_cost) VALUES (Balti, 50)');
        $this->addSql('INSERT INTO b_pay.location (name, shipping_cost) VALUES (Ungheni, 40)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
