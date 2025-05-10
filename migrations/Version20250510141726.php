<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250510141726 extends AbstractMigration
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
        $this->addSql(<<<'SQL'
            CREATE TABLE PAYS (IDPAYS INT IDENTITY NOT NULL, CODEPAYS NVARCHAR(2) NOT NULL, LIBPAYS NVARCHAR(30) NOT NULL, PLACE NVARCHAR(8) NOT NULL, ORDRE NUMERIC(2, 0) NOT NULL, NATURE NUMERIC(1, 0) NOT NULL, CONTINENT NVARCHAR(10) NOT NULL, PRIMARY KEY (IDPAYS))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE UTILISATEUR (SEQUTIL INT IDENTITY NOT NULL, MAJ DATETIME2(6) NOT NULL, CODEUTIL NVARCHAR(6) NOT NULL, NOMUTIL NVARCHAR(30) NOT NULL, PROFILUTIL NVARCHAR(25) NOT NULL, MDP NVARCHAR(5) NOT NULL, BADGE NVARCHAR(4) NOT NULL, FLAG1 BIT NOT NULL, FLAG2 BIT NOT NULL, DATEDEB DATETIME2(6) NOT NULL, HEURED DATETIME2(6) NOT NULL, DATEFIN DATETIME2(6) NOT NULL, HEUREF DATETIME2(6) NOT NULL, ENCOURS BIT NOT NULL, SEQNIVEAU INT NOT NULL, emailutil NVARCHAR(50) NOT NULL, WEBLOGIN NVARCHAR(10) NOT NULL, WEBMDP NVARCHAR(10) NOT NULL, PRIMARY KEY (SEQUTIL))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT IDENTITY NOT NULL, body VARCHAR(MAX) NOT NULL, headers VARCHAR(MAX) NOT NULL, queue_name NVARCHAR(190) NOT NULL, created_at DATETIME2(6) NOT NULL, available_at DATETIME2(6) NOT NULL, delivered_at DATETIME2(6), PRIMARY KEY (id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
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
            DROP TABLE PAYS
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE UTILISATEUR
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
