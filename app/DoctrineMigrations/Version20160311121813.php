<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Drop fucking Enum & Replace dates fields from Date to DateTime type
 */
class Version20160311121813 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE user CHANGE civility civility VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE invitation CHANGE civility civility VARCHAR(10) NOT NULL');
        $this->addSql('
            ALTER TABLE project CHANGE status status VARCHAR(255) NOT NULL,
            CHANGE begin_date begin_date DATETIME NOT NULL,
            CHANGE planned_end_date planned_end_date DATETIME NOT NULL,
            CHANGE real_end_date real_end_date DATETIME DEFAULT NULL
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE user CHANGE civility civility VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE invitation CHANGE civility civility VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('
            ALTER TABLE project CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci,
            CHANGE begin_date begin_date DATE NOT NULL,
            CHANGE planned_end_date planned_end_date DATE NOT NULL,
            CHANGE real_end_date real_end_date DATE NOT NULL
        ');
    }
}
