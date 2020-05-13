<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity({"email"}, message="Celui-ci est déjà pris")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, Serializable
{

    const DefaultRole = [
        'ROLE_USER' => 'ROLE_USER',
        'ROLE_ADMIN' => 'ROLE_ADMIN',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $channels;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MusicLibrary", mappedBy="user", orphanRemoval=true)
     */
    private $music;

    public function __construct()
    {
        $this->music = new ArrayCollection();
    }



    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

     /**
     * permet de construire le slug de facon automatique
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function initialise(){
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->username);

        }
    }
    
    public function getChannels(): ?string
    {
        return $this->channels;
    }

    public function setChannels(string $channels): self
    {
        $this->channels = $channels;

        return $this;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setRole($role): self
    {
        $this->role = $role;

        return $this;
    }


    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the role granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the role might be stored on a ``role`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return string The user role
     */
    public function getRoles()
    {
        return array($this->role);
    }

    public function getDefaultRole(): string
    {
        return self::DefaultRole[$this->role];
    }

    public function getRole(){
        return $this->role;
    }
    

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The encoded password if any
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(){}

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->email,
            $this->password 
        ]);
    }

    /**
     * @param string $serialized
     * 
     * @return void
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->email,
            $this->password
        ) = unserialize($serialized, ['allowed_classes' => false]);

    }

    /**
     * @return Collection|MusicLibrary[]
     */
    public function getMusic(): Collection
    {
        return $this->music;
    }

    public function addMusic(MusicLibrary $music): self
    {
        if (!$this->music->contains($music)) {
            $this->music[] = $music;
            $music->setUser($this);
        }

        return $this;
    }

    public function removeMusic(MusicLibrary $music): self
    {
        if ($this->music->contains($music)) {
            $this->music->removeElement($music);
            // set the owning side to null (unless already changed)
            if ($music->getUser() === $this) {
                $music->setUser(null);
            }
        }

        return $this;
    }

   

   

   


}
