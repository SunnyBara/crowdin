<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240529123236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, language_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, project_name VARCHAR(255) NOT NULL, INDEX IDX_2FB3D0EEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, source_project_id INT NOT NULL, source_translator_id INT DEFAULT NULL, source_native_language_id INT NOT NULL, source_require_language_id INT NOT NULL, source_content LONGTEXT NOT NULL, INDEX IDX_5F8A7F736AD96EB8 (source_project_id), INDEX IDX_5F8A7F73961C3569 (source_translator_id), INDEX IDX_5F8A7F737E17908E (source_native_language_id), INDEX IDX_5F8A7F73F5BCAC4 (source_require_language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL,user_state BOOLEAN NOT NULL DEFAULT 0, user_login VARCHAR(255) NOT NULL UNIQUE, user_password VARCHAR(255) NOT NULL, user_name VARCHAR(255) NOT NULL, is_translator TINYINT(1) DEFAULT 0 NOT NULL, is_product_owner TINYINT(1) DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_language (user_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_345695B5A76ED395 (user_id), INDEX IDX_345695B582F1BAF4 (language_id), PRIMARY KEY(user_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE source ADD CONSTRAINT FK_5F8A7F736AD96EB8 FOREIGN KEY (source_project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE source ADD CONSTRAINT FK_5F8A7F73961C3569 FOREIGN KEY (source_translator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE source ADD CONSTRAINT FK_5F8A7F737E17908E FOREIGN KEY (source_native_language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE source ADD CONSTRAINT FK_5F8A7F73F5BCAC4 FOREIGN KEY (source_require_language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE user_language ADD CONSTRAINT FK_345695B5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_language ADD CONSTRAINT FK_345695B582F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEA76ED395');
        $this->addSql('ALTER TABLE source DROP FOREIGN KEY FK_5F8A7F736AD96EB8');
        $this->addSql('ALTER TABLE source DROP FOREIGN KEY FK_5F8A7F73961C3569');
        $this->addSql('ALTER TABLE source DROP FOREIGN KEY FK_5F8A7F737E17908E');
        $this->addSql('ALTER TABLE source DROP FOREIGN KEY FK_5F8A7F73F5BCAC4');
        $this->addSql('ALTER TABLE user_language DROP FOREIGN KEY FK_345695B5A76ED395');
        $this->addSql('ALTER TABLE user_language DROP FOREIGN KEY FK_345695B582F1BAF4');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_language');
    }
}
