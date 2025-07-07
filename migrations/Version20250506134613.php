<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250506134613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE location CHANGE lat lat NUMERIC(20, 16) NOT NULL, CHANGE lng lng NUMERIC(20, 16) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE map CHANGE lat lat NUMERIC(20, 16) NOT NULL, CHANGE lng lng NUMERIC(20, 16) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE location CHANGE lat lat NUMERIC(10, 10) NOT NULL, CHANGE lng lng NUMERIC(10, 10) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE map CHANGE lat lat NUMERIC(10, 10) NOT NULL, CHANGE lng lng NUMERIC(10, 10) NOT NULL
        SQL);
    }
}
