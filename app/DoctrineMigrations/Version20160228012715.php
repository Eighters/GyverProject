<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Create table Invitation
 */
class Version20160228012715 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE invitation (code VARCHAR(6) NOT NULL, email VARCHAR(256) NOT NULL, is_sent TINYINT(1) NOT NULL, sent_at DATETIME NOT NULL, PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD invitation_id VARCHAR(6) DEFAULT NULL, CHANGE civility civility enum(\'male\', \'female\')');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A35D7AF0 FOREIGN KEY (invitation_id) REFERENCES invitation (code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A35D7AF0 ON user (invitation_id)');
        $this->addSql('ALTER TABLE project CHANGE status status enum(\'Waiting validation\')');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A35D7AF0');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('ALTER TABLE project CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX UNIQ_8D93D649A35D7AF0 ON user');
        $this->addSql('ALTER TABLE user DROP invitation_id, CHANGE civility civility VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
