<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190625103503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE publication_forum ADD topic_id INT DEFAULT NULL, CHANGE user_name user_name LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE publication_forum ADD CONSTRAINT FK_60F5F8411F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('CREATE INDEX IDX_60F5F8411F55203D ON publication_forum (topic_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE publication_forum DROP FOREIGN KEY FK_60F5F8411F55203D');
        $this->addSql('DROP INDEX IDX_60F5F8411F55203D ON publication_forum');
        $this->addSql('ALTER TABLE publication_forum DROP topic_id, CHANGE user_name user_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
