<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=30,minMessage="Le champs doit contenir au moins 2 charactères",maxMessage="Le champs ne doit pas depasser  30 charactères")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=30,minMessage="Le champs doit contenir au moins 2 charactères",maxMessage="Le champs ne doit pas depasser 30 charactères")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     * @Assert\Email(message="Veuillez renseigner un Email valide")
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status = 0;

    /**
     * @var checkbox|null
     *  @Assert\IsTrue(message="Veuillez prendre connaissance des conditions général et chocher la case.")
     */
    private $check;

    /**
     * met en place la date de création
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function prePersist(){
        if(empty($this->created_at)){
            $this->created_at = new \DateTime('now');
        }

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of check
     *
     * @return  string|null
     */ 
    public function getCheck()
    {
        return $this->check;
    }

    /**
     * Set the value of message
     *
     * @param  checkbox|null  $check
     *
     * @return  self
     */ 
    public function setCheck($check)
    {
        $this->check = $check;

        return $this;
    }
}
