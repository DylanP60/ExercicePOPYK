<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OffreRepository")
 */
class Offre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contrat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_contrat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_job;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Competence")
     */
    private $id_competence;

    public function __construct()
    {
        $this->id_competence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdContrat(): ?contrat
    {
        return $this->id_contrat;
    }

    public function setIdContrat(?contrat $id_contrat): self
    {
        $this->id_contrat = $id_contrat;

        return $this;
    }

    public function getIdJob(): ?job
    {
        return $this->id_job;
    }

    public function setIdJob(?job $id_job): self
    {
        $this->id_job = $id_job;

        return $this;
    }

    /**
     * @return Collection|competence[]
     */
    public function getIdCompetence(): Collection
    {
        return $this->id_competence;
    }

    public function addIdCompetence(competence $idCompetence): self
    {
        if (!$this->id_competence->contains($idCompetence)) {
            $this->id_competence[] = $idCompetence;
        }

        return $this;
    }

    public function removeIdCompetence(competence $idCompetence): self
    {
        if ($this->id_competence->contains($idCompetence)) {
            $this->id_competence->removeElement($idCompetence);
        }

        return $this;
    }
}
