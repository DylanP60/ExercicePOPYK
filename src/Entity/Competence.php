<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetenceRepository")
 */
class Competence
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Offre")
     */
    private $id_offre;

    public function __construct()
    {
        $this->id_offre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|offre[]
     */
    public function getIdOffre(): Collection
    {
        return $this->id_offre;
    }

    public function addIdOffre(offre $idOffre): self
    {
        if (!$this->id_offre->contains($idOffre)) {
            $this->id_offre[] = $idOffre;
        }

        return $this;
    }

    public function removeIdOffre(offre $idOffre): self
    {
        if ($this->id_offre->contains($idOffre)) {
            $this->id_offre->removeElement($idOffre);
        }

        return $this;
    }
}
