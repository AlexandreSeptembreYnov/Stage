<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OuvrageRepository")
 */
class Ouvrage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Numero;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Auteur")
     * @ORM\JoinColumn(name="Auteur_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $Auteur_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Titre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Theme")
     * @ORM\JoinColumn(name="Theme_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)  
     */
    private $Theme_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero()
    {
        return $this->Numero;
    }

    public function setNumero($Numero): self
    {
        $this->Numero = $Numero;

        return $this;
    }

    public function getAuteurId()
    {
        if($this->Auteur_id == null){
            return null;
        }
        return $this->Auteur_id;
    }

    public function setAuteurId($Auteur_id): self
    {
        $this->Auteur_id = $Auteur_id;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getThemeId()
    {
        if($this->Theme_id == null){
            return null;
        }
        return $this->Theme_id;
    }

    public function setThemeId($Theme_id): self
    {
        $this->Theme_id = $Theme_id;

        return $this;
    }
}
