<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add description fields to Project & Company entity
 */
class Version20160214013452 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE company ADD description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE project ADD description LONGTEXT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE company DROP description');
        $this->addSql('ALTER TABLE project DROP description');
    }
}
