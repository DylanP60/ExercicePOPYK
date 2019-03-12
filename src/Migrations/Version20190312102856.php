<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312102856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE competence_offre (competence_id INT NOT NULL, offre_id INT NOT NULL, INDEX IDX_25A4D78915761DAB (competence_id), INDEX IDX_25A4D7894CC8505A (offre_id), PRIMARY KEY(competence_id, offre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_competence (offre_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_B98A0F5A4CC8505A (offre_id), INDEX IDX_B98A0F5A15761DAB (competence_id), PRIMARY KEY(offre_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence_offre ADD CONSTRAINT FK_25A4D78915761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence_offre ADD CONSTRAINT FK_25A4D7894CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_competence ADD CONSTRAINT FK_B98A0F5A4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_competence ADD CONSTRAINT FK_B98A0F5A15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre ADD id_job_id INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F2DD7FB44 FOREIGN KEY (id_job_id) REFERENCES job (id)');
        $this->addSql('CREATE INDEX IDX_AF86866F2DD7FB44 ON offre (id_job_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE competence_offre');
        $this->addSql('DROP TABLE offre_competence');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F2DD7FB44');
        $this->addSql('DROP INDEX IDX_AF86866F2DD7FB44 ON offre');
        $this->addSql('ALTER TABLE offre DROP id_job_id');
    }
}
