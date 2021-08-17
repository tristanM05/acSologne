<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActuRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *  fields={"title"},
 *  message="une autre actualité possède déja ce titre, Merci de la modifié"
 * )
 */
class Actu
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photos", mappedBy="actu",fetch="EAGER")
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
        $this->slug = $slugify->slugify($this->title);
    }

    /**
     * met en place la date de création
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function prePersist(){
        if(empty($this->createdAt)){
            $this->createdAt = new \DateTime('now');
        }

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
            $image->setActu($this);
        }

        return $this;
    }

    public function removeImage(Photos $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getActu() === $this) {
                $image->setActu(null);
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
