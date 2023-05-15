<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426072800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal_user DROP FOREIGN KEY FK_974D05BD639666D6');
        $this->addSql('ALTER TABLE meal_user DROP FOREIGN KEY FK_974D05BDA76ED395');
        $this->addSql('DROP TABLE meal_user');
        $this->addSql('ALTER TABLE meal ADD fk_user_id INT DEFAULT NULL, ADD approved TINYINT(1) NOT NULL, ADD ingredients VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9C5741EEB9 ON meal (fk_user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meal_user (meal_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_974D05BD639666D6 (meal_id), INDEX IDX_974D05BDA76ED395 (user_id), PRIMARY KEY(meal_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE meal_user ADD CONSTRAINT FK_974D05BD639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_user ADD CONSTRAINT FK_974D05BDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C5741EEB9');
        $this->addSql('DROP INDEX IDX_9EF68E9C5741EEB9 ON meal');
        $this->addSql('ALTER TABLE meal DROP fk_user_id, DROP approved, DROP ingredients');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
