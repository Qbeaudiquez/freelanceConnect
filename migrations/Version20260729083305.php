<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260729083305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY `FK_A45BDDC19D86650F`');
        $this->addSql('DROP INDEX IDX_A45BDDC19D86650F ON application');
        $this->addSql('ALTER TABLE application CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC1A76ED395 ON application (user_id)');
        $this->addSql('ALTER TABLE archive_mission DROP FOREIGN KEY `FK_FD4713C39D86650F`');
        $this->addSql('DROP INDEX IDX_FD4713C39D86650F ON archive_mission');
        $this->addSql('ALTER TABLE archive_mission CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE archive_mission ADD CONSTRAINT FK_FD4713C3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_FD4713C3A76ED395 ON archive_mission (user_id)');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY `FK_36AC99F19D86650F`');
        $this->addSql('DROP INDEX IDX_36AC99F19D86650F ON link');
        $this->addSql('ALTER TABLE link CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_36AC99F1A76ED395 ON link (user_id)');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY `FK_9067F23C9D86650F`');
        $this->addSql('DROP INDEX IDX_9067F23C9D86650F ON mission');
        $this->addSql('ALTER TABLE mission CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_9067F23CA76ED395 ON mission (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1A76ED395');
        $this->addSql('DROP INDEX IDX_A45BDDC1A76ED395 ON application');
        $this->addSql('ALTER TABLE application CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT `FK_A45BDDC19D86650F` FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A45BDDC19D86650F ON application (user_id_id)');
        $this->addSql('ALTER TABLE archive_mission DROP FOREIGN KEY FK_FD4713C3A76ED395');
        $this->addSql('DROP INDEX IDX_FD4713C3A76ED395 ON archive_mission');
        $this->addSql('ALTER TABLE archive_mission CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE archive_mission ADD CONSTRAINT `FK_FD4713C39D86650F` FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FD4713C39D86650F ON archive_mission (user_id_id)');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F1A76ED395');
        $this->addSql('DROP INDEX IDX_36AC99F1A76ED395 ON link');
        $this->addSql('ALTER TABLE link CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT `FK_36AC99F19D86650F` FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_36AC99F19D86650F ON link (user_id_id)');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CA76ED395');
        $this->addSql('DROP INDEX IDX_9067F23CA76ED395 ON mission');
        $this->addSql('ALTER TABLE mission CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT `FK_9067F23C9D86650F` FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9067F23C9D86650F ON mission (user_id_id)');
    }
}
