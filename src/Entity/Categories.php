<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()

 */
class Categories
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
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Machines", mappedBy="categories",fetch="EAGER")
     */
    private $machine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tarifs;
    /**
     *@Vich\UploadableField(mapping="pdf_files",fileNameProperty="tarifs")
     */
    private $tarifFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Formation", mappedBy="categories")
     */
    private $formations;


    public function __construct()
    {
        $this->machine = new ArrayCollection();
        $this->formation = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|machines[]
     */
    public function getMachine(): Collection
    {
        return $this->machine;
    }

    public function addMachine(machines $machine): self
    {
        if (!$this->machine->contains($machine)) {
            $this->machine[] = $machine;
            $machine->setCategories($this);
        }

        return $this;
    }

    public function removeMachine(machines $machine): self
    {
        if ($this->machine->contains($machine)) {
            $this->machine->removeElement($machine);
            // set the owning side to null (unless already changed)
            if ($machine->getCategories() === $this) {
                $machine->setCategories(null);
            }
        }

        return $this;
    }

    public function getTarifs()
    {
        return $this->tarifs;
    }

    public function setTarifs($tarifs): self
    {
        $this->tarifs = $tarifs;

        return $this;
    }


    /**
     * Get the value of getTarifFile
     */
    public function getTarifFile()
    {
        return $this->tarifFile;
    }

    /**
     * Set the value of imageFile
     *
     * @return  self
     */
    public function setTarifFile(?File $tarifFile = null): self
    {
        $this->tarifFile = $tarifFile;
        if ($this->tarifFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate 
     */
    public function setEmptyUpDate()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setCategories($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
            // set the owning side to null (unless already changed)
            if ($formation->getCategories() === $this) {
                $formation->setCategories(null);
            }
        }

        return $this;
    }

}
