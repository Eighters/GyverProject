<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add Creation Date to Company Table & new association between Project Category and Company
 */
class Version20160424185207 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE project_category ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_category ADD CONSTRAINT FK_3B02921A979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_3B02921A979B1AD6 ON project_category (company_id)');
        $this->addSql('ALTER TABLE company ADD creation_date DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE company DROP creation_date');
        $this->addSql('ALTER TABLE project_category DROP FOREIGN KEY FK_3B02921A979B1AD6');
        $this->addSql('DROP INDEX IDX_3B02921A979B1AD6 ON project_category');
        $this->addSql('ALTER TABLE project_category DROP company_id');
    }
}
