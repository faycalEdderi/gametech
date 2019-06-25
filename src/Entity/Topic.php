<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TopicRepository")
 */
class Topic
{

    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="CategoryTopic", inversedBy="topic")
     * @ORM\JoinColumn(name="category_topic_id", referencedColumnName="id")
     */
    private $categoryTopic;


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sujet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $auteur;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
	 * un topic est relié à plusieurs publication
	 * NE PAS OUBLIER : ajouter l'alias ORM
	 * @ORM\OneToMany(targetEntity="PublicationForum", mappedBy="topic")
	 */
    private $publication;
    
    public function __construct()
    {
        
        $this->commentaire = new ArrayCollection();
        $this->publication = new ArrayCollection();
    }






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCategoryTopic(): ?CategoryTopic
    {
        return $this->categoryTopic;
    }

    public function setCategoryTopic(?CategoryTopic $categoryTopic): self
    {
        $this->categoryTopic = $categoryTopic;

        return $this;
    }

    /**
     * @return Collection|PublicationForum[]
     */
    public function getPublication(): Collection
    {
        return $this->publication;
    }

    public function addPublication(PublicationForum $publication): self
    {
        if (!$this->publication->contains($publication)) {
            $this->publication[] = $publication;
            $publication->setTopic($this);
        }

        return $this;
    }

    public function removePublication(PublicationForum $publication): self
    {
        if ($this->publication->contains($publication)) {
            $this->publication->removeElement($publication);
            // set the owning side to null (unless already changed)
            if ($publication->getTopic() === $this) {
                $publication->setTopic(null);
            }
        }

        return $this;
    }
}
