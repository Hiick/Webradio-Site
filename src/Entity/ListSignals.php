<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListSignalsRepository")
 */
class ListSignals
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fluxAudio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateDebutStream;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateHeureSignalement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFluxAudio(): ?string
    {
        return $this->fluxAudio;
    }

    public function setFluxAudio(string $fluxAudio): self
    {
        $this->fluxAudio = $fluxAudio;

        return $this;
    }

    public function getDateDebutStream(): ?string
    {
        return $this->dateDebutStream;
    }

    public function setDateDebutStream(string $dateDebutStream): self
    {
        $this->dateDebutStream = $dateDebutStream;

        return $this;
    }

    public function getDateHeureSignalement(): ?string
    {
        return $this->dateHeureSignalement;
    }

    public function setDateHeureSignalement(string $dateHeureSignalement): self
    {
        $this->dateHeureSignalement = $dateHeureSignalement;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }
}
