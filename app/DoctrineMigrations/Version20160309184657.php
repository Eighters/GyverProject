<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add User information (username, firstname, lastname & civility) to Invitation table for autocomplete user registration forms
 */
class Version20160309184657 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE invitation
            ADD userName VARCHAR(80) NOT NULL,
            ADD firstName VARCHAR(80) NOT NULL,
            ADD lastName VARCHAR(80) NOT NULL,
            ADD civility enum(\'male\', \'female\'),
            CHANGE confirmation_token confirmation_token VARCHAR(64) NOT NULL
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE invitation
            DROP userName,
            DROP firstName,
            DROP lastName,
            DROP civility,
            CHANGE confirmation_token confirmation_token VARCHAR(128) NOT NULL
        ');
    }
}
