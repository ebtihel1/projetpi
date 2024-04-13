<?php

namespace App\Entity;

use App\Repository\DiplomeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiplomeRepository::class)]
class Diplome
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private \DateTimeInterface $Date_Debut;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private \DateTimeInterface $Date_Fin;

    #[ORM\Column(length: 255)]
    private string $Mention;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->Date_Debut;
    }

    public function setDateDebut(\DateTimeInterface $Date_Debut): self
    {
        $this->Date_Debut = $Date_Debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->Date_Fin;
    }

    public function setDateFin(\DateTimeInterface $Date_Fin): self
    {
        $this->Date_Fin = $Date_Fin;

        return $this;
    }

    public function getMention(): ?string
    {
        return $this->Mention;
    }

    public function setMention(string $Mention): self
    {
        $this->Mention = $Mention;

        return $this;
    }
}
