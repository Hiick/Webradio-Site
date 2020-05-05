<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SignalementsRepository")
 */
class Signalements
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
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomChaine;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreSignal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $listSignal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $management;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getNomChaine(): ?string
    {
        return $this->nomChaine;
    }

    public function getSlug() :string
    {
        return (new Slugify())->slugify($this->nomChaine); 
    }

    public function setNomChaine(string $nomChaine): self
    {
        $this->nomChaine = $nomChaine;

        return $this;
    }

    public function getNombreSignal(): ?string
    {
        return $this->nombreSignal;
    }

    public function setNombreSignal(string $nombreSignal): self
    {
        $this->nombreSignal = $nombreSignal;

        return $this;
    }

    public function getListSignal(): ?string
    {
        return $this->listSignal;
    }

    public function setListSignal(string $listSignal): self
    {
        $this->listSignal = $listSignal;

        return $this;
    }

    public function getManagement(): ?string
    {
        return $this->management;
    }

    public function setManagement(string $management): self
    {
        $this->management = $management;

        return $this;
    }
}
