<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotosRepository")
 */
class Photos
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
    private $src;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Actu", inversedBy="images",fetch="EAGER")
     */
    private $actu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Machines", inversedBy="images",fetch="EAGER")
     */
    private $machines;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="images",fetch="EAGER")
     */
    private $album;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation", inversedBy="images",fetch="EAGER")
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Annonce", inversedBy="images",fetch="EAGER")
     */
    private $annonce;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    public function getActu(): ?Actu
    {
        return $this->actu;
    }

    public function setActu(?Actu $actu): self
    {
        $this->actu = $actu;

        return $this;
    }

    public function getMachines(): ?Machines
    {
        return $this->machines;
    }

    public function setMachines(?Machines $machines): self
    {
        $this->machines = $machines;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

}
