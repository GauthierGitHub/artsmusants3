<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190430234743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sales (id INT AUTO_INCREMENT NOT NULL, painting_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, date DATE NOT NULL, canceled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_6B817044B00EB939 (painting_id), INDEX IDX_6B8170449395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customers (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, postalcode VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bookings (id INT AUTO_INCREMENT NOT NULL, painting_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, date DATE NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, canceled TINYINT(1) NOT NULL, INDEX IDX_7A853C35B00EB939 (painting_id), INDEX IDX_7A853C359395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paintings (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, height SMALLINT NOT NULL, width SMALLINT NOT NULL, year SMALLINT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_CDBED50812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B817044B00EB939 FOREIGN KEY (painting_id) REFERENCES paintings (id)');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B8170449395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C35B00EB939 FOREIGN KEY (painting_id) REFERENCES paintings (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C359395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE paintings ADD CONSTRAINT FK_CDBED50812469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B8170449395C3F3');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C359395C3F3');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B817044B00EB939');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C35B00EB939');
        $this->addSql('ALTER TABLE paintings DROP FOREIGN KEY FK_CDBED50812469DE2');
        $this->addSql('DROP TABLE sales');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE bookings');
        $this->addSql('DROP TABLE paintings');
        $this->addSql('DROP TABLE categories');
    }
}
