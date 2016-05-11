<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Rename join table from user_company to company_users
 * Create join table between projects & companies
 * Drop old unnecessary field customerCompany & supplierCompany from Project
 */
class Version20160511234133 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE TABLE company_users (
                user_id INT NOT NULL,
                company_id INT NOT NULL,
                INDEX IDX_5372078CA76ED395 (user_id),
                INDEX IDX_5372078C979B1AD6 (company_id),
                PRIMARY KEY(user_id, company_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE company_projects (
                company_id INT NOT NULL,
                project_id INT NOT NULL,
                INDEX IDX_4404A6C9979B1AD6 (company_id),
                INDEX IDX_4404A6C9166D1F9C (project_id),
                PRIMARY KEY(company_id, project_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE company_users ADD CONSTRAINT FK_5372078CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_users ADD CONSTRAINT FK_5372078C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_projects ADD CONSTRAINT FK_4404A6C9979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_projects ADD CONSTRAINT FK_4404A6C9166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_company');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE5362ADF1');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EECEDA7D50');
        $this->addSql('DROP INDEX IDX_2FB3D0EE5362ADF1 ON project');
        $this->addSql('DROP INDEX IDX_2FB3D0EECEDA7D50 ON project');
        $this->addSql('ALTER TABLE project DROP customer_company, DROP supplier_company');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('CREATE TABLE user_company (user_id INT NOT NULL, company_id INT NOT NULL, INDEX IDX_17B21745A76ED395 (user_id), INDEX IDX_17B21745979B1AD6 (company_id), PRIMARY KEY(user_id, company_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_company ADD CONSTRAINT FK_17B21745979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_company ADD CONSTRAINT FK_17B21745A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE company_users');
        $this->addSql('DROP TABLE company_projects');
        $this->addSql('ALTER TABLE project ADD customer_company INT NOT NULL, ADD supplier_company INT NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE5362ADF1 FOREIGN KEY (customer_company) REFERENCES company (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EECEDA7D50 FOREIGN KEY (supplier_company) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE5362ADF1 ON project (customer_company)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EECEDA7D50 ON project (supplier_company)');
    }
}
