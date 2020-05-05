<?php
namespace App\Entity;

class UserSearch {

    /**
     * @var string|null
     */
    private $username;

    /**
    * @var string|null
    */
    private $channels;


    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): UserSearch
    {
        $this->username = $username;
        return $this;
    }

    public function getChannels(): ?string
    {
        return $this->channels;
    }

    public function setChannels(string $channels): UserSearch
    {
        $this->channels = $channels;
        return $this;
    }


}