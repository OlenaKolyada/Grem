<?php

namespace App\Entity;

use App\Enum\CommentStatusEnum;
use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Comment
{
    public const string GROUP_GET_COMMENT = 'getComment';
    public const string GROUP_GET_COMMENT_COLLECTION = 'getCommentCollection';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups([
        self::GROUP_GET_COMMENT,
        self::GROUP_GET_COMMENT_COLLECTION
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Content cannot be empty')]
    #[Groups([
        self::GROUP_GET_COMMENT,
        self::GROUP_GET_COMMENT_COLLECTION
    ])]
    private ?string $content = null;

    #[ORM\Column(type: Types::STRING, enumType: CommentStatusEnum::class)]
    #[Assert\NotBlank(message: 'Status cannot be empty.')]
    #[Groups([
        self::GROUP_GET_COMMENT,
        self::GROUP_GET_COMMENT_COLLECTION
    ])]
    private ?CommentStatusEnum $status = null;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: true, onDelete: "CASCADE")]
    #[Groups([
        self::GROUP_GET_COMMENT,
        self::GROUP_GET_COMMENT_COLLECTION
    ])]
    private ?User $author = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        self::GROUP_GET_COMMENT,
        self::GROUP_GET_COMMENT_COLLECTION
    ])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        self::GROUP_GET_COMMENT,
        self::GROUP_GET_COMMENT_COLLECTION
    ])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    #[Assert\NotNull(message: 'Review cannot be null')]
    #[Groups([
        self::GROUP_GET_COMMENT,
        self::GROUP_GET_COMMENT_COLLECTION
    ])]
    private ?Review $review = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?CommentStatusEnum
    {
        return $this->status;
    }

    public function setStatus(CommentStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getReview(): ?Review
    {
        return $this->review;
    }

    public function setReview(?Review $review): static
    {
        $this->review = $review;

        return $this;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
}
