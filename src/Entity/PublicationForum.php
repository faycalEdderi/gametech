<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PublicationForumRepository")
 */
class PublicationForum
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reponse;

      /**
	
	 * @ORM\ManyToOne(targetEntity="Topic", inversedBy="publication")
	 * @ORM\JoinColumn(name="topic_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	private $topic;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }
}
