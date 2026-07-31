<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260731141005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application_link (application_id INT NOT NULL, link_id INT NOT NULL, INDEX IDX_C140F1793E030ACD (application_id), INDEX IDX_C140F179ADA40271 (link_id), PRIMARY KEY (application_id, link_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE application_link ADD CONSTRAINT FK_C140F1793E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application_link ADD CONSTRAINT FK_C140F179ADA40271 FOREIGN KEY (link_id) REFERENCES link (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application_link DROP FOREIGN KEY FK_C140F1793E030ACD');
        $this->addSql('ALTER TABLE application_link DROP FOREIGN KEY FK_C140F179ADA40271');
        $this->addSql('DROP TABLE application_link');
    }
}
