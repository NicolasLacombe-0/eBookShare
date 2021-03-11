<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311121517 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ebook ADD CONSTRAINT FK_7D51730D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_7D51730D12469DE2 ON ebook (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP image');
        $this->addSql('ALTER TABLE ebook DROP FOREIGN KEY FK_7D51730D12469DE2');
        $this->addSql('DROP INDEX IDX_7D51730D12469DE2 ON ebook');
    }
}
