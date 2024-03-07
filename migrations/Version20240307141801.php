<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307141801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE film_genre (film_id INT NOT NULL, genre_id INT NOT NULL, PRIMARY KEY(film_id, genre_id))');
        $this->addSql('CREATE INDEX IDX_1A3CCDA8567F5183 ON film_genre (film_id)');
        $this->addSql('CREATE INDEX IDX_1A3CCDA84296D31F ON film_genre (genre_id)');
        $this->addSql('CREATE TABLE genre (id INT NOT NULL, genre VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE film_genre ADD CONSTRAINT FK_1A3CCDA8567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film_genre ADD CONSTRAINT FK_1A3CCDA84296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE genre_id_seq CASCADE');
        $this->addSql('ALTER TABLE film_genre DROP CONSTRAINT FK_1A3CCDA8567F5183');
        $this->addSql('ALTER TABLE film_genre DROP CONSTRAINT FK_1A3CCDA84296D31F');
        $this->addSql('DROP TABLE film_genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('ALTER TABLE film ALTER description TYPE TEXT');
    }
}
