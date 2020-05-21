<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200520134910 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE skill_result_index (id INT AUTO_INCREMENT NOT NULL, skill_id INT NOT NULL, average INT NOT NULL, children_average INT NOT NULL, children_highest INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_result_index_user (skill_result_index_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1B726CDD15F71E17 (skill_result_index_id), INDEX IDX_1B726CDDA76ED395 (user_id), PRIMARY KEY(skill_result_index_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_result_index (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, skill_id INT NOT NULL, result INT NOT NULL, children_average INT DEFAULT NULL, children_highest INT DEFAULT NULL, INDEX IDX_914B4C8FA76ED395 (user_id), INDEX IDX_914B4C8F5585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill_result_index_user ADD CONSTRAINT FK_1B726CDD15F71E17 FOREIGN KEY (skill_result_index_id) REFERENCES skill_result_index (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_result_index_user ADD CONSTRAINT FK_1B726CDDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_result_index ADD CONSTRAINT FK_914B4C8FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_result_index ADD CONSTRAINT FK_914B4C8F5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492ED8ABA4 FOREIGN KEY (root_skill_id) REFERENCES skill (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6492ED8ABA4 ON user (root_skill_id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1131E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1135585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_136AC1131E27F6BF ON result (question_id)');
        $this->addSql('CREATE INDEX IDX_136AC1135585C142 ON result (skill_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_136AC113A76ED395 ON result (user_id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477727ACA70 FOREIGN KEY (parent_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4771E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE477727ACA70 ON skill (parent_id)');
        $this->addSql('CREATE INDEX IDX_5E3DE4771E27F6BF ON skill (question_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE skill_result_index_user DROP FOREIGN KEY FK_1B726CDD15F71E17');
        $this->addSql('DROP TABLE skill_result_index');
        $this->addSql('DROP TABLE skill_result_index_user');
        $this->addSql('DROP TABLE user_result_index');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1131E27F6BF');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1135585C142');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113A76ED395');
        $this->addSql('DROP INDEX UNIQ_136AC1131E27F6BF ON result');
        $this->addSql('DROP INDEX IDX_136AC1135585C142 ON result');
        $this->addSql('DROP INDEX UNIQ_136AC113A76ED395 ON result');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477727ACA70');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4771E27F6BF');
        $this->addSql('DROP INDEX IDX_5E3DE477727ACA70 ON skill');
        $this->addSql('DROP INDEX IDX_5E3DE4771E27F6BF ON skill');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492ED8ABA4');
        $this->addSql('DROP INDEX IDX_8D93D6492ED8ABA4 ON user');
    }
}
