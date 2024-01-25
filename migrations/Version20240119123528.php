<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119123528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asso_award (id INT AUTO_INCREMENT NOT NULL, id_award_id INT NOT NULL, id_book_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_FA01318F6D896E5A (id_award_id), UNIQUE INDEX UNIQ_FA01318FC83F1AF1 (id_book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE asso_cat (id INT AUTO_INCREMENT NOT NULL, id_book_id INT DEFAULT NULL, id_category_id INT NOT NULL, UNIQUE INDEX UNIQ_C046AF47C83F1AF1 (id_book_id), UNIQUE INDEX UNIQ_C046AF47A545015 (id_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE awarded (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name_cat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, id_book_id INT NOT NULL, name_group VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_6DC044C5C83F1AF1 (id_book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE in_group (id INT AUTO_INCREMENT NOT NULL, id_group_id INT NOT NULL, id_user_id INT NOT NULL, UNIQUE INDEX UNIQ_27355ABBAE8F35D2 (id_group_id), INDEX IDX_27355ABB79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE the_place (id INT AUTO_INCREMENT NOT NULL, name_place VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE the_reunion (id INT AUTO_INCREMENT NOT NULL, id_group_id INT NOT NULL, id_place_id INT NOT NULL, date_reunion DATETIME NOT NULL, UNIQUE INDEX UNIQ_BBD28A64AE8F35D2 (id_group_id), UNIQUE INDEX UNIQ_BBD28A645D7D4E8C (id_place_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, pseudonym VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, relation_id INT NOT NULL, direction VARCHAR(255) NOT NULL, postal_code INT NOT NULL, town VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, tel INT NOT NULL, UNIQUE INDEX UNIQ_B1087D9E3256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE ch_cookieconsent_log (id INT AUTO_INCREMENT PRIMARY KEY, ip_address VARCHAR(255), cookie_consent_key VARCHAR(255), cookie_name VARCHAR(255), cookie_value VARCHAR(255), timestamp DATETIME)');

        $this->addSql('ALTER TABLE asso_award ADD CONSTRAINT FK_FA01318F6D896E5A FOREIGN KEY (id_award_id) REFERENCES awarded (id)');
        $this->addSql('ALTER TABLE asso_award ADD CONSTRAINT FK_FA01318FC83F1AF1 FOREIGN KEY (id_book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE asso_cat ADD CONSTRAINT FK_C046AF47C83F1AF1 FOREIGN KEY (id_book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE asso_cat ADD CONSTRAINT FK_C046AF47A545015 FOREIGN KEY (id_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5C83F1AF1 FOREIGN KEY (id_book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE in_group ADD CONSTRAINT FK_27355ABBAE8F35D2 FOREIGN KEY (id_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE in_group ADD CONSTRAINT FK_27355ABB79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE the_reunion ADD CONSTRAINT FK_BBD28A64AE8F35D2 FOREIGN KEY (id_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE the_reunion ADD CONSTRAINT FK_BBD28A645D7D4E8C FOREIGN KEY (id_place_id) REFERENCES the_place (id)');
        $this->addSql('ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9E3256915B FOREIGN KEY (relation_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asso_award DROP FOREIGN KEY FK_FA01318F6D896E5A');
        $this->addSql('ALTER TABLE asso_award DROP FOREIGN KEY FK_FA01318FC83F1AF1');
        $this->addSql('ALTER TABLE asso_cat DROP FOREIGN KEY FK_C046AF47C83F1AF1');
        $this->addSql('ALTER TABLE asso_cat DROP FOREIGN KEY FK_C046AF47A545015');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C5C83F1AF1');
        $this->addSql('ALTER TABLE in_group DROP FOREIGN KEY FK_27355ABBAE8F35D2');
        $this->addSql('ALTER TABLE in_group DROP FOREIGN KEY FK_27355ABB79F37AE5');
        $this->addSql('ALTER TABLE the_reunion DROP FOREIGN KEY FK_BBD28A64AE8F35D2');
        $this->addSql('ALTER TABLE the_reunion DROP FOREIGN KEY FK_BBD28A645D7D4E8C');
        $this->addSql('ALTER TABLE user_info DROP FOREIGN KEY FK_B1087D9E3256915B');
        $this->addSql('DROP TABLE asso_award');
        $this->addSql('DROP TABLE asso_cat');
        $this->addSql('DROP TABLE awarded');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE in_group');
        $this->addSql('DROP TABLE the_place');
        $this->addSql('DROP TABLE the_reunion');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_info');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE ch_cookieconsent_log');
    }
}
