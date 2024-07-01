<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701190114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_tags (question_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_315279C91E27F6BF (question_id), INDEX IDX_315279C98D7B4FB4 (tags_id), PRIMARY KEY(question_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_tags ADD CONSTRAINT FK_315279C91E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_tags ADD CONSTRAINT FK_315279C98D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions_tags DROP FOREIGN KEY FK_721C30741E27F6BF');
        $this->addSql('ALTER TABLE questions_tags DROP FOREIGN KEY FK_721C30748D7B4FB4');
        $this->addSql('DROP TABLE questions_tags');
        $this->addSql('ALTER TABLE answers CHANGE best_answer best_answer TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE questions_tags (question_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_721C30748D7B4FB4 (tags_id), INDEX IDX_721C30741E27F6BF (question_id), PRIMARY KEY(question_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE questions_tags ADD CONSTRAINT FK_721C30741E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions_tags ADD CONSTRAINT FK_721C30748D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_tags DROP FOREIGN KEY FK_315279C91E27F6BF');
        $this->addSql('ALTER TABLE question_tags DROP FOREIGN KEY FK_315279C98D7B4FB4');
        $this->addSql('DROP TABLE question_tags');
        $this->addSql('ALTER TABLE answers CHANGE best_answer best_answer TINYINT(1) NOT NULL');
    }
}
