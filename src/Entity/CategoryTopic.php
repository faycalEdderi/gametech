<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryTopicRepository")
 */
class CategoryTopic
{

    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Topic", mappedBy="categoryTopic")
     */
    private $topic;


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category_name;

    public function __construct()
    {
        $this->topic = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopic(): Collection
    {
        return $this->topic;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topic->contains($topic)) {
            $this->topic[] = $topic;
            $topic->setTopic($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topic->contains($topic)) {
            $this->topic->removeElement($topic);
            // set the owning side to null (unless already changed)
            if ($topic->getTopic() === $this) {
                $topic->setTopic(null);
            }
        }

        return $this;
    }
}
