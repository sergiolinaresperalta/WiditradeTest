<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215103247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            INSERT INTO `user` (`email`, `roles`, `password`)
            VALUES
                (\'admin-email@example.com\', \'["ROLE_ADMIN"]\', \'$2y$13$b1lQmZzHPTI7JAFDjmMaK.CG6fz6WYy5yNyi50RMBdI4o6zS.iZAq\');
            '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM `user` WHERE `email` = \'admin-email@example.com\';');
    }
}
