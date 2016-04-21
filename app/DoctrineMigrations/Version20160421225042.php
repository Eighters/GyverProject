<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add customerCompany & supplierCompany field to Project entity
 */
class Version20160421225042 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE project ADD customer_company INT NOT NULL, ADD supplier_company INT NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE5362ADF1 FOREIGN KEY (customer_company) REFERENCES company (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EECEDA7D50 FOREIGN KEY (supplier_company) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE5362ADF1 ON project (customer_company)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EECEDA7D50 ON project (supplier_company)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE5362ADF1');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EECEDA7D50');
        $this->addSql('DROP INDEX IDX_2FB3D0EE5362ADF1 ON project');
        $this->addSql('DROP INDEX IDX_2FB3D0EECEDA7D50 ON project');
        $this->addSql('ALTER TABLE project DROP customer_company, DROP supplier_company');
    }
}
