<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact{

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=30,minMessage="Le champs doit contenir au moins 2 charactères",maxMessage="Le champs ne doit pas depasser 30 charactères")
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=30,minMessage="Le champs doit contenir au moins 2 charactères",maxMessage="Le champs ne doit pas depasser 30 charactères")
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max="10", minMessage="Le numero de téléphone est incorrect, il doit contenir au moins 10 chiffres", maxMessage="Le numero de téléphone est incorect, il ne doit pas dépasser 10 chiffres")
     * pattern="/[0-9]{10}/"
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     * @Assert\Email(message="Veuillez renseigner un Email valide")
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10, minMessage="Votre message doit contenir au moins 10 charactères")
     */
    private $message;


    /**
     * Get the value of firstname
     *
     * @return  string|null
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string|null  $firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     *
     * @return  string|null
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string|null  $lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get pattern="/[0-9]{10}/"
     *
     * @return  string|null
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set pattern="/[0-9]{10}/"
     *
     * @param  string|null  $phone  pattern="/[0-9]{10}/"
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  string|null
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string|null  $email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of message
     *
     * @return  string|null
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @param  string|null  $message
     *
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of property
     *
     * @return  Property|null
     */ 
    public function getProperty()
    {
        return $this->property;
    }

}