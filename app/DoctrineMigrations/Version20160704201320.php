<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add creation_date field to Project table
 */
class Version20160704201320 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE project ADD creation_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE project CHANGE begin_date begin_date DATETIME DEFAULT NULL, CHANGE planned_end_date planned_end_date DATETIME DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE project DROP creation_date');
        $this->addSql('ALTER TABLE project CHANGE begin_date begin_date DATETIME NOT NULL, CHANGE planned_end_date planned_end_date DATETIME NOT NULL');
    }
}
