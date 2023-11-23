<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123161631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, id_book INT NOT NULL, id_user INT NOT NULL, creation_date DATETIME NOT NULL, reunion_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, pseudonym VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, direction VARCHAR(255) NOT NULL, postal_code INT NOT NULL, town VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE cfg_config_portabilite');
        $this->addSql('DROP TABLE pfi_portability_files_treated');
        $this->addSql('DROP TABLE pfi_portability_files_treated_history');
        $this->addSql('DROP TABLE pnu_ported_numbers');
        $this->addSql('DROP TABLE pnu_ported_numbers_copy');
        $this->addSql('DROP TABLE pnu_ported_numbers_history');
        $this->addSql('DROP TABLE pnu_ported_numbers_history_copy');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cfg_config_portabilite (cfg_id INT AUTO_INCREMENT NOT NULL, cfg_ex_type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cfg_code_gie VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cfg_label_gie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cfg_msisdn_country_filter VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, cfg_prefix_country VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cfg_code_operateur VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cfg_label_hcnx VARCHAR(80) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX cfg_ex_type (cfg_ex_type), PRIMARY KEY(cfg_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pfi_portability_files_treated (pfi_id BIGINT AUTO_INCREMENT NOT NULL, pfi_path TEXT CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci` COMMENT \'full path\', pfi_status VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci` COMMENT \'integrated or not_valid\', pfi_lines INT NOT NULL COMMENT \'Lines integrated\', pfi_createdate DATETIME NOT NULL, INDEX pfi_createdate (pfi_createdate), PRIMARY KEY(pfi_id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pfi_portability_files_treated_history (pfi_id BIGINT AUTO_INCREMENT NOT NULL, pfi_path TEXT CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci` COMMENT \'full path\', pfi_status VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci` COMMENT \'integrated or not_valid\', pfi_lines INT NOT NULL COMMENT \'Lines integrated\', pfi_createdate DATETIME NOT NULL, INDEX pfi_createdate (pfi_createdate), PRIMARY KEY(pfi_id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pnu_ported_numbers (pnu_id BIGINT AUTO_INCREMENT NOT NULL, pnu_number VARCHAR(20) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, pnu_opr_network_id VARCHAR(10) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, pnu_valid TINYINT(1) DEFAULT NULL, pnu_createdate DATETIME DEFAULT NULL, pnu_ex VARCHAR(5) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, UNIQUE INDEX pnu_number (pnu_number), INDEX pnu_createdate (pnu_createdate), INDEX pnu_opr_network_id (pnu_opr_network_id), PRIMARY KEY(pnu_id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pnu_ported_numbers_copy (pnu_id BIGINT AUTO_INCREMENT NOT NULL, pnu_number VARCHAR(20) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, pnu_opr_network_id VARCHAR(10) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, pnu_valid TINYINT(1) DEFAULT NULL, pnu_createdate DATETIME DEFAULT NULL, pnu_ex VARCHAR(5) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, INDEX pnu_createdate (pnu_createdate), UNIQUE INDEX pnu_number (pnu_number), INDEX pnu_opr_network_id (pnu_opr_network_id), PRIMARY KEY(pnu_id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pnu_ported_numbers_history (pnu_id BIGINT AUTO_INCREMENT NOT NULL, pnu_number VARCHAR(20) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`, pnu_opr_network_id VARCHAR(10) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`, pnu_valid TINYINT(1) DEFAULT NULL, pnu_invalid_date DATE DEFAULT \'0000-00-00\' NOT NULL, pnu_createdate DATETIME DEFAULT NULL, pnu_integrated_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, pnu_origine_file VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, pnu_ex VARCHAR(5) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, UNIQUE INDEX pnu_number (pnu_number, pnu_opr_network_id, pnu_invalid_date), INDEX pnu_origine_file (pnu_origine_file), PRIMARY KEY(pnu_id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pnu_ported_numbers_history_copy (pnu_id BIGINT AUTO_INCREMENT NOT NULL, pnu_number VARCHAR(20) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`, pnu_opr_network_id VARCHAR(10) CHARACTER SET latin1 DEFAULT \'\' NOT NULL COLLATE `latin1_swedish_ci`, pnu_valid TINYINT(1) DEFAULT NULL, pnu_invalid_date DATE DEFAULT \'0000-00-00\' NOT NULL, pnu_createdate DATETIME DEFAULT NULL, pnu_integrated_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, pnu_origine_file VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, pnu_ex VARCHAR(5) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, INDEX pnu_origine_file (pnu_origine_file), UNIQUE INDEX pnu_number (pnu_number, pnu_opr_network_id, pnu_invalid_date), INDEX pnu_id (pnu_id), PRIMARY KEY(pnu_id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_info');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
