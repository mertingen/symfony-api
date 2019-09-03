<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190902202347 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE edge DROP INDEX UNIQ_7506D366460D9FD7, ADD INDEX IDX_7506D366460D9FD7 (node_id)');
        $this->addSql('ALTER TABLE edge DROP INDEX UNIQ_7506D3665D4BE7AA, ADD INDEX IDX_7506D3665D4BE7AA (directed_node_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE edge DROP INDEX IDX_7506D366460D9FD7, ADD UNIQUE INDEX UNIQ_7506D366460D9FD7 (node_id)');
        $this->addSql('ALTER TABLE edge DROP INDEX IDX_7506D3665D4BE7AA, ADD UNIQUE INDEX UNIQ_7506D3665D4BE7AA (directed_node_id)');
    }
}
