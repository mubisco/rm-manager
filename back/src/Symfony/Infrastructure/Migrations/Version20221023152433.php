<?php

declare(strict_types=1);

namespace App\Symfony\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221023152433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users
            CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            CHANGE reset_password_requested_at reset_password_requested_at DATETIME DEFAULT NULL
                COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users
            CHANGE created_at created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\',
            CHANGE updated_at updated_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\',
            CHANGE reset_password_requested_at reset_password_requested_at DATE DEFAULT NULL
                COMMENT \'(DC2Type:date_immutable)\'');
    }
}
