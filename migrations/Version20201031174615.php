<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201031174615 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create Schedule with all Request';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO `schedule` VALUES (1, 0, 2, 5, '09:00:00', '11:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (2, 0, 3, 5, '09:00:00', '11:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (3, 0, 1, 10, '09:00:00', '10:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (4, 0, 1, 20, '11:00:00', '18:20:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (5, 0, 2, 20, '11:00:00', '18:20:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (6, 0, 3, 20, '11:00:00', '18:20:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (7, 1, 0, 4, '14:00:00', '15:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (8, 2, 0, 4, '14:00:00', '15:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (9, 3, 0, 4, '14:00:00', '15:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (10, 2, 0, 7, '15:00:00', '16:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (11, 3, 0, 7, '15:00:00', '16:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (12, 0, 1, 7, '15:00:00', '16:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (13, 0, 3, 7, '15:00:00', '16:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (14, 1, 0, 3, '18:00:00', '20:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (15, 2, 0, 3, '18:00:00', '20:00:00')");
        $this->addSql("INSERT INTO `schedule` VALUES (16, 3, 0, 3, '18:00:00', '20:00:00')");

        $this->addSql("INSERT INTO `elevator` VALUES (1, 0, 0, 0)");
        $this->addSql("INSERT INTO `elevator` VALUES (2, 3, 0, 0)");
        $this->addSql("INSERT INTO `elevator` VALUES (3, 2, 0, 0)");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
