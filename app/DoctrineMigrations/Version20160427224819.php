<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160427224819 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE TABLE user_access (
                user_id INT NOT NULL,
                access_role_id INT NOT NULL,
                INDEX IDX_633B3069A76ED395 (user_id),
                INDEX IDX_633B30691E26F8B9 (access_role_id),
                PRIMARY KEY(user_id, access_role_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE access_role (
                id INT AUTO_INCREMENT NOT NULL,
                company_id INT DEFAULT NULL,
                project_id INT DEFAULT NULL,
                type VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                description VARCHAR(1000) NOT NULL,
                INDEX IDX_A1B0EC6C979B1AD6 (company_id),
                INDEX IDX_A1B0EC6C166D1F9C (project_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE user_access ADD CONSTRAINT FK_633B3069A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_access ADD CONSTRAINT FK_633B30691E26F8B9 FOREIGN KEY (access_role_id) REFERENCES access_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE access_role ADD CONSTRAINT FK_A1B0EC6C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE access_role ADD CONSTRAINT FK_A1B0EC6C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('DROP TABLE company_role');
        $this->addSql('DROP TABLE project_role');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_access DROP FOREIGN KEY FK_633B30691E26F8B9');
        $this->addSql('CREATE TABLE company_role (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_role (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE user_access');
        $this->addSql('DROP TABLE access_role');
    }
}
