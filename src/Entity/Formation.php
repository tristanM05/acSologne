<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormationRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"title"},
 * message="une autre actualité possède déja ce titre, Merci de la modifié"
 * )
 */
class Formation
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="formations")
     */
    private $categories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photos", mappedBy="formation",fetch="EAGER")
     */
    private $images;

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
        $this->slug = $slugify->slugify($this->title);
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
            $image->setFormation($this);
        }

        return $this;
    }

    public function removeImage(Photos $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getFormation() === $this) {
                $image->setFormation(null);
            }
        }

        return $this;
    }

}
