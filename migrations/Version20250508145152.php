<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250508145152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE UTILISATEUR (SEQUTIL INT IDENTITY NOT NULL, MAJ DATETIME2(6) NOT NULL, CODEUTIL NVARCHAR(6) NOT NULL, NOMUTIL NVARCHAR(30) NOT NULL, PROFILUTIL NVARCHAR(25) NOT NULL, MDP NVARCHAR(5) NOT NULL, BADGE NVARCHAR(4) NOT NULL, FLAG1 BIT NOT NULL, FLAG2 BIT NOT NULL, DATEDEB DATETIME2(6) NOT NULL, HEURED DATETIME2(6) NOT NULL, DATEFIN DATETIME2(6) NOT NULL, HEUREF DATETIME2(6) NOT NULL, ENCOURS BIT NOT NULL, SEQNIVEAU INT NOT NULL, emailutil NVARCHAR(50) NOT NULL, WEBLOGIN NVARCHAR(10) NOT NULL, WEBMDP NVARCHAR(10) NOT NULL, PRIMARY KEY (SEQUTIL))
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
            DROP TABLE UTILISATEUR
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
