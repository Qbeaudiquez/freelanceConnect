<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260729082010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, motivation LONGTEXT NOT NULL, created_at DATETIME NOT NULL, cv_url VARCHAR(255) NOT NULL, status_application_id INT NOT NULL, mission_id INT NOT NULL, user_id_id INT NOT NULL, INDEX IDX_A45BDDC1BE4BA557 (status_application_id), INDEX IDX_A45BDDC1BE6CAE90 (mission_id), INDEX IDX_A45BDDC19D86650F (user_id_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE archive_mission (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(150) NOT NULL, description LONGTEXT NOT NULL, budget DOUBLE PRECISION NOT NULL, deadline DATETIME NOT NULL, language VARCHAR(50) NOT NULL, advance_rate INT NOT NULL, advance_paid INT DEFAULT NULL, created_at DATETIME NOT NULL, archived_at DATETIME NOT NULL, status_mission_id INT NOT NULL, user_id_id INT NOT NULL, INDEX IDX_FD4713C3BF3F4A16 (status_mission_id), INDEX IDX_FD4713C39D86650F (user_id_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ban (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, ip VARCHAR(15) NOT NULL, banned_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, paid_at DATETIME DEFAULT NULL, mission_id INT NOT NULL, invoice_status_id INT NOT NULL, INDEX IDX_90651744BE6CAE90 (mission_id), INDEX IDX_90651744E58F121 (invoice_status_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE invoice_status (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, url VARCHAR(255) NOT NULL, user_id_id INT NOT NULL, INDEX IDX_36AC99F19D86650F (user_id_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(150) NOT NULL, description LONGTEXT NOT NULL, budget DOUBLE PRECISION NOT NULL, deadline DATETIME NOT NULL, language VARCHAR(50) NOT NULL, advance_rate INT NOT NULL, advance_paid INT DEFAULT NULL, created_at DATETIME NOT NULL, status_mission_id INT NOT NULL, user_id_id INT NOT NULL, INDEX IDX_9067F23CBF3F4A16 (status_mission_id), INDEX IDX_9067F23C9D86650F (user_id_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE mission_category (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, mission_id INT NOT NULL, INDEX IDX_EB0187812469DE2 (category_id), INDEX IDX_EB01878BE6CAE90 (mission_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE status_application (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE status_mission (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1BE4BA557 FOREIGN KEY (status_application_id) REFERENCES status_application (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC19D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE archive_mission ADD CONSTRAINT FK_FD4713C3BF3F4A16 FOREIGN KEY (status_mission_id) REFERENCES status_mission (id)');
        $this->addSql('ALTER TABLE archive_mission ADD CONSTRAINT FK_FD4713C39D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744E58F121 FOREIGN KEY (invoice_status_id) REFERENCES invoice_status (id)');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F19D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CBF3F4A16 FOREIGN KEY (status_mission_id) REFERENCES status_mission (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission_category ADD CONSTRAINT FK_EB0187812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE mission_category ADD CONSTRAINT FK_EB01878BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1BE4BA557');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1BE6CAE90');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC19D86650F');
        $this->addSql('ALTER TABLE archive_mission DROP FOREIGN KEY FK_FD4713C3BF3F4A16');
        $this->addSql('ALTER TABLE archive_mission DROP FOREIGN KEY FK_FD4713C39D86650F');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744BE6CAE90');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744E58F121');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F19D86650F');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CBF3F4A16');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C9D86650F');
        $this->addSql('ALTER TABLE mission_category DROP FOREIGN KEY FK_EB0187812469DE2');
        $this->addSql('ALTER TABLE mission_category DROP FOREIGN KEY FK_EB01878BE6CAE90');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE archive_mission');
        $this->addSql('DROP TABLE ban');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE invoice_status');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE mission_category');
        $this->addSql('DROP TABLE status_application');
        $this->addSql('DROP TABLE status_mission');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
