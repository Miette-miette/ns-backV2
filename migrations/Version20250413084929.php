<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413084929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE artist ADD img VARCHAR(255) NOT NULL, ADD updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD location_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA764D218E FOREIGN KEY (location_id) REFERENCES location (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3BAE0AA764D218E ON event (location_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE info_location ADD updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE location ADD updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE news ADD updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partner ADD updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE artist DROP img, DROP updated_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA764D218E
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_3BAE0AA764D218E ON event
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP location_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE info_location DROP updated_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE location DROP updated_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE news DROP updated_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE partner DROP updated_at
        SQL);
    }
}
