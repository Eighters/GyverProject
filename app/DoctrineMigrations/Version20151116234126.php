<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151116234126 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_compagny (user_id INT NOT NULL, compagny_id INT NOT NULL, INDEX IDX_F7289E04A76ED395 (user_id), INDEX IDX_F7289E041224ABE0 (compagny_id), PRIMARY KEY(user_id, compagny_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_compagny ADD CONSTRAINT FK_F7289E04A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_compagny ADD CONSTRAINT FK_F7289E041224ABE0 FOREIGN KEY (compagny_id) REFERENCES compagny (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE compagny ADD name VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_compagny');
        $this->addSql('ALTER TABLE compagny DROP name');
    }
}
