<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240202151454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film ADD release_date DATE NOT NULL');
        $this->addSql('ALTER TABLE film ADD country VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE film ADD budget INT NOT NULL');
        $this->addSql('ALTER TABLE film ALTER description TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE film DROP release_date');
        $this->addSql('ALTER TABLE film DROP country');
        $this->addSql('ALTER TABLE film DROP budget');
        $this->addSql('ALTER TABLE film ALTER description TYPE TEXT');
    }
}
