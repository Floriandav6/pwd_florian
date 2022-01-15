<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115105247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo_gallery ADD photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photo_gallery ADD CONSTRAINT FK_72CB6FB77E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('CREATE INDEX IDX_72CB6FB77E9E4C8C ON photo_gallery (photo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo_gallery DROP FOREIGN KEY FK_72CB6FB77E9E4C8C');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP INDEX IDX_72CB6FB77E9E4C8C ON photo_gallery');
        $this->addSql('ALTER TABLE photo_gallery DROP photo_id');
    }
}
