<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdate
{
    
    private $oldPassword;

    /**
     * @Assert\Length(min=7,minMessage="votre mot de pass doit faire au moins 7 caractères")
     */
    private $newPassWord;

    /**
     * @Assert\EqualTo(propertyPath="newPassWord",message="vous n'avez pas confirmer le mot de pass")
     */
    private $confimPassWord;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassWord(): ?string
    {
        return $this->newPassWord;
    }

    public function setNewPassWord(string $newPassWord): self
    {
        $this->newPassWord = $newPassWord;

        return $this;
    }

    public function getConfimPassWord(): ?string
    {
        return $this->confimPassWord;
    }

    public function setConfimPassWord(string $confimPassWord): self
    {
        $this->confimPassWord = $confimPassWord;

        return $this;
    }
}
