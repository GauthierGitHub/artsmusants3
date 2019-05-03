<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190501014058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sales CHANGE canceled canceled TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62534E21E7927C74 ON customers (email)');
        $this->addSql('ALTER TABLE bookings CHANGE canceled canceled TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE paintings ADD title VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CDBED5082B36786B ON paintings (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF346685E237E06 ON categories (name)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bookings CHANGE canceled canceled TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_3AF346685E237E06 ON categories');
        $this->addSql('DROP INDEX UNIQ_62534E21E7927C74 ON customers');
        $this->addSql('DROP INDEX UNIQ_CDBED5082B36786B ON paintings');
        $this->addSql('ALTER TABLE paintings DROP title');
        $this->addSql('ALTER TABLE sales CHANGE canceled canceled TINYINT(1) NOT NULL');
    }
}
