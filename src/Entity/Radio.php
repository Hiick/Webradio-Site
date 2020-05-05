<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RadioRepository")
 */
class Radio
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
    private $nameRadio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlRadio;

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

    public function getNameRadio(): ?string
    {
        return $this->nameRadio;
    }

    public function setNameRadio(string $nameRadio): self
    {
        $this->nameRadio = $nameRadio;

        return $this;
    }

    public function getUrlRadio(): ?string
    {
        return $this->urlRadio;
    }

    public function setUrlRadio(string $urlRadio): self
    {
        $this->urlRadio = $urlRadio;

        return $this;
    }
}
