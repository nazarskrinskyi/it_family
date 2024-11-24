<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124143653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family_members CHANGE health health INT DEFAULT 100, CHANGE energy energy INT DEFAULT 100, CHANGE mood mood INT DEFAULT 50, CHANGE state state VARCHAR(255) DEFAULT \'normal\', CHANGE hunger hunger INT DEFAULT 50, CHANGE stress stress INT DEFAULT 50');
        $this->addSql('ALTER TABLE main_characters CHANGE health health INT DEFAULT 100, CHANGE energy energy INT DEFAULT 100, CHANGE mood mood INT DEFAULT 50, CHANGE state state VARCHAR(255) DEFAULT \'normal\', CHANGE hunger hunger INT DEFAULT 50, CHANGE stress stress INT DEFAULT 50');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family_members CHANGE health health INT DEFAULT 100 NOT NULL, CHANGE energy energy INT DEFAULT 100 NOT NULL, CHANGE mood mood INT DEFAULT 50 NOT NULL, CHANGE state state VARCHAR(255) DEFAULT \'normal\' NOT NULL, CHANGE hunger hunger INT DEFAULT 50 NOT NULL, CHANGE stress stress INT DEFAULT 50 NOT NULL');
        $this->addSql('ALTER TABLE main_characters CHANGE health health INT DEFAULT 100 NOT NULL, CHANGE energy energy INT DEFAULT 100 NOT NULL, CHANGE mood mood INT DEFAULT 50 NOT NULL, CHANGE state state VARCHAR(255) DEFAULT \'normal\' NOT NULL, CHANGE hunger hunger INT DEFAULT 50 NOT NULL, CHANGE stress stress INT DEFAULT 50 NOT NULL');
    }
}
