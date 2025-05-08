<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250508153034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE PARAMETRE (SEQPARAM INT IDENTITY NOT NULL, ENTETE1 NVARCHAR(25) NOT NULL, ENTETE2 NVARCHAR(25) NOT NULL, ADRESSE NVARCHAR(30) NOT NULL, CP NVARCHAR(10) NOT NULL, VILLE NVARCHAR(20) NOT NULL, PAYS NVARCHAR(20) NOT NULL, TEL NVARCHAR(16) NOT NULL, FAX NVARCHAR(16) NOT NULL, EMAIL NVARCHAR(50) NOT NULL, SEQRESA INT NOT NULL, CONTACTFR NVARCHAR(50) NOT NULL, CONTACT NVARCHAR(50) NOT NULL, EURO DOUBLE PRECISION NOT NULL, EXPEDITEUR NVARCHAR(50) NOT NULL, ALERTE BIT NOT NULL, BTOBVOL DOUBLE PRECISION NOT NULL, TEL2 NVARCHAR(20) NOT NULL, TEL3 NVARCHAR(20) NOT NULL, TEL4 NVARCHAR(20) NOT NULL, MARGE DOUBLE PRECISION NOT NULL, PRIMARY KEY (SEQPARAM))
        SQL);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA db_accessadmin
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SCHEMA db_backupoperator
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SCHEMA db_datareader
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SCHEMA db_datawriter
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SCHEMA db_ddladmin
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SCHEMA db_denydatareader
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SCHEMA db_denydatawriter
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SCHEMA db_owner
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SCHEMA db_securityadmin
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SCHEMA dbo
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE PARAMETRE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
