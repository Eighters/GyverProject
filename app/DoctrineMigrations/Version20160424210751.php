<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add Unique index to the Company, Project & Project Category Tables
 */
class Version20160424210751 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE UNIQUE INDEX name ON project_category (name)');
        $this->addSql('CREATE UNIQUE INDEX name ON company (name)');
        $this->addSql('CREATE UNIQUE INDEX name ON project (name)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP INDEX name ON company');
        $this->addSql('DROP INDEX name ON project');
        $this->addSql('DROP INDEX name ON project_category');
    }
}
