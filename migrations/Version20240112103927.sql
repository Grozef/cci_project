<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112103927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asso_award ( id INT AUTO_INCREMENT NOT NULL, id_award INT NOT NULL, id_book INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');


        $this->addSql('CREATE TABLE asso_cat (id INT AUTO_INCREMENT NOT NULL, id_cat INT NOT NULL, id_book INT NOT NULL, PRIMARY KEY(id)) CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE awarded (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, id_category INT NOT NULL, id_awarded INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name_cat VARCHAR(255) NOT NULL, id_book INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, id_book INT NOT NULL, name_group VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE in_group (id INT AUTO_INCREMENT NOT NULL, id_group INT NOT NULL, id_user INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE the_place (id INT AUTO_INCREMENT NOT NULL, name_place VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE the_reunion (id INT AUTO_INCREMENT NOT NULL, date_reunion DATETIME NOT NULL, id_group INT NOT NULL, id_place INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, pseudonym VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, direction VARCHAR(255) NOT NULL, postal_code INT NOT NULL, town VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE asso_award ADD CONSTRAINT fk_asso_award_book1 FOREIGN KEY (id_book) REFERENCES book (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        $this->addSql('ALTER TABLE asso_award ADD CONSTRAINT fk_asso_award_awarded FOREIGN KEY (id_award) REFERENCES awarded (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        
        $this->addSql('ALTER TABLE asso_cat ADD CONSTRAINT fk_asso_cat_book FOREIGN KEY (id_book) REFERENCES book (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        $this->addSql('ALTER TABLE asso_cat ADD CONSTRAINT fk_asso_cat_category FOREIGN KEY (id_cat) REFERENCES category (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        
        $this->addSql('ALTER TABLE book ADD CONSTRAINT fk_book_asso_category FOREIGN KEY (id_category) REFERENCES asso_cat (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT fk_book_asso_award FOREIGN KEY (id_awarded) REFERENCES asso_award (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        
        $this->addSql(' ALTER TABLE category ADD CONSTRAINT fk_category_asso_cat FOREIGN KEY (id) REFERENCES asso_cat (id_cat) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        
        $this->addSql(' ALTER TABLE `group` ADD CONSTRAINT fk_group_book FOREIGN KEY (id_book) REFERENCES book (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        
        $this->addSql(' ALTER TABLE in_group ADD CONSTRAINT fk_ingroup_user FOREIGN KEY (id_user) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        $this->addSql(' ALTER TABLE in_group ADD CONSTRAINT fk_ingroup_group FOREIGN KEY (id_group) REFERENCES `group` (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        
        $this->addSql(' ALTER TABLE the_reunion ADD CONSTRAINT fk_reunion_group FOREIGN KEY (id_group) REFERENCES `group` (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
        $this->addSql(' ALTER TABLE the_reunion ADD CONSTRAINT fk_reunion_place FOREIGN KEY (id_place) REFERENCES the_place (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
       
        $this->addSql(' ALTER TABLE user_info ADD CONSTRAINT fk_user_info_user FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE NO ACTION ON UPDATE NO ACTION;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
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
    }
}
