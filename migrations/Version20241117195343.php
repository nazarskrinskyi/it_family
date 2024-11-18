<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241117195343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answers (id INT AUTO_INCREMENT NOT NULL, dialog_id INT NOT NULL, content LONGTEXT NOT NULL, reactions VARCHAR(255) DEFAULT NULL, emoji VARCHAR(10) DEFAULT NULL, INDEX IDX_50D0C6065E46C4E2 (dialog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dialogs (id INT AUTO_INCREMENT NOT NULL, parent_dialog_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, selected_answer INT DEFAULT NULL, emoji VARCHAR(10) DEFAULT NULL, reactions VARCHAR(255) DEFAULT NULL, INDEX IDX_B8F7AEA7AF0DEB0C (parent_dialog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dialog_members (dialog_id INT NOT NULL, family_member_id INT NOT NULL, INDEX IDX_68B1D2A05E46C4E2 (dialog_id), INDEX IDX_68B1D2A0BC594993 (family_member_id), PRIMARY KEY(dialog_id, family_member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_members (id INT AUTO_INCREMENT NOT NULL, main_character_id INT NOT NULL, name VARCHAR(255) NOT NULL, age INT NOT NULL, role_in_family VARCHAR(255) DEFAULT NULL, role_in_it_team VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_28B4064388E0BCC (main_character_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE main_characters (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, age INT NOT NULL, role_in_family VARCHAR(255) DEFAULT NULL, role_in_it_team VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6065E46C4E2 FOREIGN KEY (dialog_id) REFERENCES dialogs (id)');
        $this->addSql('ALTER TABLE dialogs ADD CONSTRAINT FK_B8F7AEA7AF0DEB0C FOREIGN KEY (parent_dialog_id) REFERENCES dialogs (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE dialog_members ADD CONSTRAINT FK_68B1D2A05E46C4E2 FOREIGN KEY (dialog_id) REFERENCES dialogs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dialog_members ADD CONSTRAINT FK_68B1D2A0BC594993 FOREIGN KEY (family_member_id) REFERENCES family_members (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_members ADD CONSTRAINT FK_28B4064388E0BCC FOREIGN KEY (main_character_id) REFERENCES main_characters (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6065E46C4E2');
        $this->addSql('ALTER TABLE dialogs DROP FOREIGN KEY FK_B8F7AEA7AF0DEB0C');
        $this->addSql('ALTER TABLE dialog_members DROP FOREIGN KEY FK_68B1D2A05E46C4E2');
        $this->addSql('ALTER TABLE dialog_members DROP FOREIGN KEY FK_68B1D2A0BC594993');
        $this->addSql('ALTER TABLE family_members DROP FOREIGN KEY FK_28B4064388E0BCC');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE answers');
        $this->addSql('DROP TABLE dialogs');
        $this->addSql('DROP TABLE dialog_members');
        $this->addSql('DROP TABLE family_members');
        $this->addSql('DROP TABLE main_characters');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
