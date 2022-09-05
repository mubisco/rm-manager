<?php

declare(strict_types=1);

namespace App\Symfony\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905225437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE persistible_event
            CHANGE ocurred_on ocurred_on DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE persistible_event
            CHANGE event_id event_id VARCHAR(36) NOT NULL COLLATE `utf8mb4_unicode_ci`,
            CHANGE event_body event_body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`,
            CHANGE event_type event_type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`,
            CHANGE ocurred_on ocurred_on DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }
}
