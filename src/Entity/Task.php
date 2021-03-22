<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\Table
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private \Datetime $createdAt;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     */
    private string $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     */
    private string $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isDone;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?user $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     */
    private ?\DateTimeInterface $endDate;

    public function __construct()
    {
        $this->createdAt = new \Datetime('now');
        $this->isDone = false;
    }

    public function getCurrentDate(): \DateTime
    {
        return new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): \Datetime
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function isDone(): bool
    {
        return $this->isDone;
    }

    public function toggle($flag)
    {
        $this->isDone = $flag;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface|null $endDate
     * @return Task
     */
    public function setEndDate(?\DateTimeInterface $endDate): Task
    {
        $this->endDate = $endDate;
        return $this;
    }




}


