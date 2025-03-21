<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321215129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, review_id INT NOT NULL, content LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526C3E2E969B (review_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, summary LONGTEXT NOT NULL, release_date_world DATE DEFAULT NULL, release_date_france DATE DEFAULT NULL, platform_requirements_level VARCHAR(255) NOT NULL, age_rating VARCHAR(255) NOT NULL, cover VARCHAR(255) DEFAULT NULL, language JSON DEFAULT NULL, screenshot JSON DEFAULT NULL, trailer VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_news (game_id INT NOT NULL, news_id INT NOT NULL, INDEX IDX_F6C6F57CE48FD905 (game_id), INDEX IDX_F6C6F57CB5A459A0 (news_id), PRIMARY KEY(game_id, news_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_review (game_id INT NOT NULL, review_id INT NOT NULL, INDEX IDX_4762C0EE48FD905 (game_id), INDEX IDX_4762C0E3E2E969B (review_id), PRIMARY KEY(game_id, review_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_developer (game_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_B75D4A98E48FD905 (game_id), INDEX IDX_B75D4A9864DD9267 (developer_id), PRIMARY KEY(game_id, developer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_publisher (game_id INT NOT NULL, publisher_id INT NOT NULL, INDEX IDX_4E4E1444E48FD905 (game_id), INDEX IDX_4E4E144440C86FCE (publisher_id), PRIMARY KEY(game_id, publisher_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_genre (game_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_B1634A77E48FD905 (game_id), INDEX IDX_B1634A774296D31F (genre_id), PRIMARY KEY(game_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_platform (game_id INT NOT NULL, platform_id INT NOT NULL, INDEX IDX_92162FEDE48FD905 (game_id), INDEX IDX_92162FEDFFE6496F (platform_id), PRIMARY KEY(game_id, platform_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, summary LONGTEXT NOT NULL, cover VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1DD39950F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_tag (news_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_BE3ED8A1B5A459A0 (news_id), INDEX IDX_BE3ED8A1BAD26311 (tag_id), PRIMARY KEY(news_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE platform (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publisher (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, summary LONGTEXT NOT NULL, cover VARCHAR(255) DEFAULT NULL, game_rating INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_794381C6F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_tag (review_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_FBEBB4A3E2E969B (review_id), INDEX IDX_FBEBB4ABAD26311 (tag_id), PRIMARY KEY(review_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, nickname VARCHAR(255) NOT NULL, twitch_account VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), UNIQUE INDEX UNIQ_USER_NICKNAME (nickname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token LONGTEXT NOT NULL, session_id VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, is_revoked TINYINT(1) NOT NULL, INDEX IDX_BDF55A63A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C3E2E969B FOREIGN KEY (review_id) REFERENCES review (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_news ADD CONSTRAINT FK_F6C6F57CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_news ADD CONSTRAINT FK_F6C6F57CB5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_review ADD CONSTRAINT FK_4762C0EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_review ADD CONSTRAINT FK_4762C0E3E2E969B FOREIGN KEY (review_id) REFERENCES review (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_developer ADD CONSTRAINT FK_B75D4A98E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_developer ADD CONSTRAINT FK_B75D4A9864DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_publisher ADD CONSTRAINT FK_4E4E1444E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_publisher ADD CONSTRAINT FK_4E4E144440C86FCE FOREIGN KEY (publisher_id) REFERENCES publisher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_genre ADD CONSTRAINT FK_B1634A77E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_genre ADD CONSTRAINT FK_B1634A774296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_platform ADD CONSTRAINT FK_92162FEDE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_platform ADD CONSTRAINT FK_92162FEDFFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950F675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE news_tag ADD CONSTRAINT FK_BE3ED8A1B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_tag ADD CONSTRAINT FK_BE3ED8A1BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6F675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE review_tag ADD CONSTRAINT FK_FBEBB4A3E2E969B FOREIGN KEY (review_id) REFERENCES review (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review_tag ADD CONSTRAINT FK_FBEBB4ABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_token ADD CONSTRAINT FK_BDF55A63A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C3E2E969B');
        $this->addSql('ALTER TABLE game_news DROP FOREIGN KEY FK_F6C6F57CE48FD905');
        $this->addSql('ALTER TABLE game_news DROP FOREIGN KEY FK_F6C6F57CB5A459A0');
        $this->addSql('ALTER TABLE game_review DROP FOREIGN KEY FK_4762C0EE48FD905');
        $this->addSql('ALTER TABLE game_review DROP FOREIGN KEY FK_4762C0E3E2E969B');
        $this->addSql('ALTER TABLE game_developer DROP FOREIGN KEY FK_B75D4A98E48FD905');
        $this->addSql('ALTER TABLE game_developer DROP FOREIGN KEY FK_B75D4A9864DD9267');
        $this->addSql('ALTER TABLE game_publisher DROP FOREIGN KEY FK_4E4E1444E48FD905');
        $this->addSql('ALTER TABLE game_publisher DROP FOREIGN KEY FK_4E4E144440C86FCE');
        $this->addSql('ALTER TABLE game_genre DROP FOREIGN KEY FK_B1634A77E48FD905');
        $this->addSql('ALTER TABLE game_genre DROP FOREIGN KEY FK_B1634A774296D31F');
        $this->addSql('ALTER TABLE game_platform DROP FOREIGN KEY FK_92162FEDE48FD905');
        $this->addSql('ALTER TABLE game_platform DROP FOREIGN KEY FK_92162FEDFFE6496F');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950F675F31B');
        $this->addSql('ALTER TABLE news_tag DROP FOREIGN KEY FK_BE3ED8A1B5A459A0');
        $this->addSql('ALTER TABLE news_tag DROP FOREIGN KEY FK_BE3ED8A1BAD26311');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6F675F31B');
        $this->addSql('ALTER TABLE review_tag DROP FOREIGN KEY FK_FBEBB4A3E2E969B');
        $this->addSql('ALTER TABLE review_tag DROP FOREIGN KEY FK_FBEBB4ABAD26311');
        $this->addSql('ALTER TABLE user_token DROP FOREIGN KEY FK_BDF55A63A76ED395');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_news');
        $this->addSql('DROP TABLE game_review');
        $this->addSql('DROP TABLE game_developer');
        $this->addSql('DROP TABLE game_publisher');
        $this->addSql('DROP TABLE game_genre');
        $this->addSql('DROP TABLE game_platform');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_tag');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP TABLE publisher');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE review_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_token');
    }
}
