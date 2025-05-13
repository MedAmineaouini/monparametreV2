<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250513203234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add roles column to UTILISATEUR table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE UTILISATEUR ADD roles NVARCHAR(MAX) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE UTILISATEUR DROP COLUMN roles');
    }
}