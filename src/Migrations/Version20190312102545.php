<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312102545 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidature ADD id_offre_id INT NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B81C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B81C13BCCF ON candidature (id_offre_id)');
        $this->addSql('ALTER TABLE offre ADD id_contrat_id INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBDA986C8 FOREIGN KEY (id_contrat_id) REFERENCES contrat (id)');
        $this->addSql('CREATE INDEX IDX_AF86866FBDA986C8 ON offre (id_contrat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B81C13BCCF');
        $this->addSql('DROP INDEX IDX_E33BD3B81C13BCCF ON candidature');
        $this->addSql('ALTER TABLE candidature DROP id_offre_id');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FBDA986C8');
        $this->addSql('DROP INDEX IDX_AF86866FBDA986C8 ON offre');
        $this->addSql('ALTER TABLE offre DROP id_contrat_id');
    }
}
