<?php

declare(strict_types=1);

namespace App\Nottes\Infrastructure\Persistence\Doctrine\Migrations;

use App\Nottes\Domain\Folder\FolderId;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221225124729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO folders 
                       (id, name, description, created_at, updated_at)
                       VALUES 
                       (
                         '" . FolderId::random()->value() . "',
                         '/',
                         'Root folder',
                         now(),
                         now()
                       );");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
