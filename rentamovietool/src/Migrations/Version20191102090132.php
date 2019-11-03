<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191102090132 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE camera ADD loueur_id INT NOT NULL');
        $this->addSql('ALTER TABLE camera ADD CONSTRAINT FK_3B1CEE05DAF8AEE6 FOREIGN KEY (loueur_id) REFERENCES loueur (id)');
        $this->addSql('CREATE INDEX IDX_3B1CEE05DAF8AEE6 ON camera (loueur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE camera DROP FOREIGN KEY FK_3B1CEE05DAF8AEE6');
        $this->addSql('DROP INDEX IDX_3B1CEE05DAF8AEE6 ON camera');
        $this->addSql('ALTER TABLE camera DROP loueur_id');
    }
}
