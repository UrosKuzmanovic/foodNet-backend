<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230827191812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE author ADD CONSTRAINT FK_BDAFD8C83DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_BDAFD8C83DA5256D ON author (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author DROP FOREIGN KEY FK_BDAFD8C83DA5256D');
        $this->addSql('DROP INDEX IDX_BDAFD8C83DA5256D ON author');
        $this->addSql('ALTER TABLE author DROP image_id');
    }
}
