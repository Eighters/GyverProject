<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add relationships between Project & ProjectCategory
 */
class Version20160704202155 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE project_category ADD project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_category ADD CONSTRAINT FK_3B02921A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_3B02921A166D1F9C ON project_category (project_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE project_category DROP FOREIGN KEY FK_3B02921A166D1F9C');
        $this->addSql('DROP INDEX IDX_3B02921A166D1F9C ON project_category');
        $this->addSql('ALTER TABLE project_category DROP project_id');
    }
}
