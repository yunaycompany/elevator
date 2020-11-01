<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201031174426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE elevator (id INT AUTO_INCREMENT NOT NULL, current_floor INT NOT NULL, status INT NOT NULL, floors_traveled INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, used_elevator INT DEFAULT NULL, origin_floor INT NOT NULL, destination_floor INT NOT NULL, INDEX IDX_3B978F9FD9A5FE9C (used_elevator), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_elevator (id INT AUTO_INCREMENT NOT NULL, elevator_id INT DEFAULT NULL, request_id INT DEFAULT NULL, INDEX IDX_E6BD0B16332AFBB (elevator_id), INDEX IDX_E6BD0B16427EB8A5 (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, origin_floor INT NOT NULL, destination_floor INT NOT NULL, time_interval INT NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FD9A5FE9C FOREIGN KEY (used_elevator) REFERENCES elevator (id)');
        $this->addSql('ALTER TABLE request_elevator ADD CONSTRAINT FK_E6BD0B16332AFBB FOREIGN KEY (elevator_id) REFERENCES elevator (id)');
        $this->addSql('ALTER TABLE request_elevator ADD CONSTRAINT FK_E6BD0B16427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FD9A5FE9C');
        $this->addSql('ALTER TABLE request_elevator DROP FOREIGN KEY FK_E6BD0B16332AFBB');
        $this->addSql('ALTER TABLE request_elevator DROP FOREIGN KEY FK_E6BD0B16427EB8A5');
        $this->addSql('DROP TABLE elevator');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE request_elevator');
        $this->addSql('DROP TABLE schedule');
    }
}
