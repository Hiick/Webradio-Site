<?php
namespace App\Entity;

class RadioSearch {

    /**
     * @var string|null
     */
    private $nameRadio;

    public function getNameRadio(): ?string
    {
        return $this->nameRadio;
    }

    public function setNameRadio(string $nameRadio): RadioSearch
    {
        $this->nameRadio = $nameRadio;
        return $this;
    }


}