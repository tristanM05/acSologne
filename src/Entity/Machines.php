<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MachinesRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"nom"},
 * message="une autre actualité possède déja ce titre, Merci de la modifié"
 * )
 */
class Machines
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $moteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pMoteur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $envergure;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPlace;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $vitesse;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="machine",fetch="EAGER")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photos", mappedBy="machines",fetch="EAGER")
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;


    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * permet d'initialisé le slug
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return void
     */
    public function initializeSlug(){
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($this->nom);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(?string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getMoteur(): ?string
    {
        return $this->moteur;
    }

    public function setMoteur(?string $moteur): self
    {
        $this->moteur = $moteur;

        return $this;
    }

    public function getPMoteur(): ?string
    {
        return $this->pMoteur;
    }

    public function setPMoteur(?string $pMoteur): self
    {
        $this->pMoteur = $pMoteur;

        return $this;
    }

    public function getEnvergure(): ?float
    {
        return $this->envergure;
    }

    public function setEnvergure(?float $envergure): self
    {
        $this->envergure = $envergure;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(?int $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function getVitesse(): ?int
    {
        return $this->vitesse;
    }

    public function setVitesse(?int $vitesse): self
    {
        $this->vitesse = $vitesse;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection|Photos[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Photos $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setMachines($this);
        }

        return $this;
    }

    public function removeImage(Photos $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getMachines() === $this) {
                $image->setMachines(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
