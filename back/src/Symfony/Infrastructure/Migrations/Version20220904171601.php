<?php

declare(strict_types=1);

namespace App\Symfony\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220904171601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE persistible_event CHANGE event_id event_id VARCHAR(36) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE persistible_event
            CHANGE event_id event_id VARCHAR(32) NOT NULL COLLATE `utf8mb4_unicode_ci`,
            CHANGE event_body event_body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`,
            CHANGE event_type event_type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE refresh_tokens
            CHANGE refresh_token refresh_token VARCHAR(128) NOT NULL COLLATE `utf8mb4_unicode_ci`,
            CHANGE username username VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users
            CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`,
            CHANGE username username VARCHAR(64) NOT NULL COLLATE `utf8mb4_unicode_ci`,
            CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\',
            CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`,
            CHANGE reset_password_token reset_password_token VARCHAR(64) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
