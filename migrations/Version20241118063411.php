<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241118063411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family_members ADD birth_date DATE DEFAULT NULL, ADD bio LONGTEXT DEFAULT NULL, ADD favorite_color VARCHAR(255) DEFAULT NULL, ADD hobbies JSON DEFAULT NULL, ADD personality_type VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE main_characters ADD birth_date DATE DEFAULT NULL, ADD bio LONGTEXT DEFAULT NULL, ADD favorite_color VARCHAR(255) DEFAULT NULL, ADD hobbies JSON DEFAULT NULL, ADD personality_type VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family_members DROP birth_date, DROP bio, DROP favorite_color, DROP hobbies, DROP personality_type');
        $this->addSql('ALTER TABLE main_characters DROP birth_date, DROP bio, DROP favorite_color, DROP hobbies, DROP personality_type');
    }
}
