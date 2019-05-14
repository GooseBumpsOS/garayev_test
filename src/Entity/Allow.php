<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AllowRepository")
 */
class Allow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $UserName;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $AllowTests;

    /**
     * @return mixed
     */
    public function getAllowTests()
    {
        return $this->AllowTests;
    }

    /**
     * @param mixed $AllowTests
     */
    public function setAllowTests($AllowTests): void
    {
        $this->AllowTests = $AllowTests;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->UserName;
    }

    public function setUserName(string $UserName): self
    {
        $this->UserName = $UserName;

        return $this;
    }
}
