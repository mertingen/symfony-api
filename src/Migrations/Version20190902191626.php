<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190902191626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE edge ADD node_id INT DEFAULT NULL, ADD directed_node_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE edge ADD CONSTRAINT FK_7506D366460D9FD7 FOREIGN KEY (node_id) REFERENCES node (id)');
        $this->addSql('ALTER TABLE edge ADD CONSTRAINT FK_7506D3665D4BE7AA FOREIGN KEY (directed_node_id) REFERENCES node (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7506D366460D9FD7 ON edge (node_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7506D3665D4BE7AA ON edge (directed_node_id)');
        $this->addSql('ALTER TABLE node ADD edge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE node ADD CONSTRAINT FK_857FE845696D413E FOREIGN KEY (edge_id) REFERENCES edge (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_857FE845696D413E ON node (edge_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE edge DROP FOREIGN KEY FK_7506D366460D9FD7');
        $this->addSql('ALTER TABLE edge DROP FOREIGN KEY FK_7506D3665D4BE7AA');
        $this->addSql('DROP INDEX UNIQ_7506D366460D9FD7 ON edge');
        $this->addSql('DROP INDEX UNIQ_7506D3665D4BE7AA ON edge');
        $this->addSql('ALTER TABLE edge DROP node_id, DROP directed_node_id');
        $this->addSql('ALTER TABLE node DROP FOREIGN KEY FK_857FE845696D413E');
        $this->addSql('DROP INDEX UNIQ_857FE845696D413E ON node');
        $this->addSql('ALTER TABLE node DROP edge_id');
    }
}
