<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402100927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, record_id INT DEFAULT NULL, amount INT NOT NULL, INDEX IDX_F0FE2527A76ED395 (user_id), INDEX IDX_F0FE25274DFD750C (record_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, user_id INT DEFAULT NULL, order_number VARCHAR(50) NOT NULL, order_date DATE NOT NULL, INDEX IDX_F52993986BF700BD (status_id), INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, record_id INT DEFAULT NULL, ord_id INT DEFAULT NULL, amount INT NOT NULL, INDEX IDX_52EA1F094DFD750C (record_id), INDEX IDX_52EA1F09E636D3F5 (ord_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE record (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, release_date DATE NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, image_url VARCHAR(255) NOT NULL, available_stock INT NOT NULL, reserved_stock INT NOT NULL, sold INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE record_genre (record_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_20B92A44DFD750C (record_id), INDEX IDX_20B92A44296D31F (genre_id), PRIMARY KEY(record_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE record_artist (record_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_6305D0F94DFD750C (record_id), INDEX IDX_6305D0F9B7970CF8 (artist_id), PRIMARY KEY(record_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25274DFD750C FOREIGN KEY (record_id) REFERENCES record (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094DFD750C FOREIGN KEY (record_id) REFERENCES record (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09E636D3F5 FOREIGN KEY (ord_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE record_genre ADD CONSTRAINT FK_20B92A44DFD750C FOREIGN KEY (record_id) REFERENCES record (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE record_genre ADD CONSTRAINT FK_20B92A44296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE record_artist ADD CONSTRAINT FK_6305D0F94DFD750C FOREIGN KEY (record_id) REFERENCES record (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE record_artist ADD CONSTRAINT FK_6305D0F9B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527A76ED395');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274DFD750C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986BF700BD');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094DFD750C');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09E636D3F5');
        $this->addSql('ALTER TABLE record_genre DROP FOREIGN KEY FK_20B92A44DFD750C');
        $this->addSql('ALTER TABLE record_genre DROP FOREIGN KEY FK_20B92A44296D31F');
        $this->addSql('ALTER TABLE record_artist DROP FOREIGN KEY FK_6305D0F94DFD750C');
        $this->addSql('ALTER TABLE record_artist DROP FOREIGN KEY FK_6305D0F9B7970CF8');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE record');
        $this->addSql('DROP TABLE record_genre');
        $this->addSql('DROP TABLE record_artist');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
