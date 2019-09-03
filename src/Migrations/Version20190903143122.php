<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190903143122 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE edge DROP FOREIGN KEY FK_7506D366460D9FD7');
        $this->addSql('ALTER TABLE edge DROP FOREIGN KEY FK_7506D3665D4BE7AA');
        $this->addSql('ALTER TABLE edge ADD CONSTRAINT FK_7506D366460D9FD7 FOREIGN KEY (node_id) REFERENCES node (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE edge ADD CONSTRAINT FK_7506D3665D4BE7AA FOREIGN KEY (directed_node_id) REFERENCES node (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE edge DROP FOREIGN KEY FK_7506D366460D9FD7');
        $this->addSql('ALTER TABLE edge DROP FOREIGN KEY FK_7506D3665D4BE7AA');
        $this->addSql('ALTER TABLE edge ADD CONSTRAINT FK_7506D366460D9FD7 FOREIGN KEY (node_id) REFERENCES node (id)');
        $this->addSql('ALTER TABLE edge ADD CONSTRAINT FK_7506D3665D4BE7AA FOREIGN KEY (directed_node_id) REFERENCES node (id)');
    }
}
