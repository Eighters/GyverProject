<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add besoin, origine et benefines to Project Entity
 */
class Version20170126115201 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE project 
                ADD besoin LONGTEXT NOT NULL, 
                ADD origine VARCHAR(255) NOT NULL, 
                ADD benefices LONGTEXT NOT NULL
            ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE project DROP besoin, DROP origine, DROP benefices');
    }
}
