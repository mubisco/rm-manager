<?php

declare(strict_types=1);

namespace App\Symfony\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220904153945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE persistible_event (
            event_id VARCHAR(32) NOT NULL,
            event_body LONGTEXT NOT NULL,
            event_type VARCHAR(255) NOT NULL,
            ocurred_on DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\',
            PRIMARY KEY(event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE last_event_processed');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE event (
            event_id INT AUTO_INCREMENT NOT NULL,
            event_body LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
            type_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
            ocurred_on DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\',
            PRIMARY KEY(event_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE last_event_processed (
            counter_id INT DEFAULT NULL,
            last_event INT DEFAULT NULL
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE persistible_event');
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
