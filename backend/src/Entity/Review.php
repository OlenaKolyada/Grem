<?php

namespace App\Entity;

use App\Enum\StatusEnum;
use App\Repository\ReviewRepository;
use App\Trait\AutoSlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
//#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['title'], message: 'Title should be unique.')]
#[UniqueEntity(fields: ['slug'], message: 'Slug should be unique.')]
class Review
{
    use AutoSlugTrait;
    public const string GROUP_GET_REVIEW = 'getReview';
    public const string GROUP_GET_REVIEW_COLLECTION = 'getReviewCollection';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups([
        self::GROUP_GET_REVIEW,
        self::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG,
        Comment::GROUP_GET_COMMENT,
        Comment::GROUP_GET_COMMENT_COLLECTION
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([
        self::GROUP_GET_REVIEW,
        self::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG,
        Comment::GROUP_GET_COMMENT,
        Comment::GROUP_GET_COMMENT_COLLECTION
    ])]
    #[Assert\NotBlank(message: 'Title cannot be empty')]
    #[Assert\Length(min: 3, max: 255,
        minMessage: 'Title must be at least {{ limit }} characters long',
        maxMessage: 'Title must not exceed {{ limit }} characters')]
    private ?string $title = null;

    #[Groups([
        self::GROUP_GET_REVIEW,
        self::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG,
        Comment::GROUP_GET_COMMENT,
        Comment::GROUP_GET_COMMENT_COLLECTION
    ])]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Slug cannot be longer than {{ limit }} characters.')]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'review')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    #[Groups([
        self::GROUP_GET_REVIEW,
        self::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG
    ])]
    private ?User $author = null;


    #[ORM\Column(type: Types::TEXT)]
    #[Groups([self::GROUP_GET_REVIEW])]
    #[Assert\NotBlank(message: 'Content cannot be empty')]
    #[Assert\Length(min: 10, max: 1000,
        minMessage: 'Content must be at least {{ limit }} characters long.',
        maxMessage: 'Content cannot be longer than {{ limit }} characters.')]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups([
        self::GROUP_GET_REVIEW,
        self::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG
    ])]
    #[Assert\NotBlank(message: 'Summary cannot be empty')]
    #[Assert\Length(min: 10,max: 255,
        minMessage: 'Summary must be at least {{ limit }} characters long.',
        maxMessage: 'Summary cannot be longer than {{ limit }} characters.')]
    private ?string $summary = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'The cover image URL cannot be longer than {{ limit }} characters')]
    private ?string $cover = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Groups([self::GROUP_GET_REVIEW])]
    #[Assert\NotBlank(message: 'Rating cannot be empty.')]
    #[Assert\Range(notInRangeMessage: 'The value must be between {{ min }} and {{ max }}.', min: 1, max: 10)]
    private ?int $gameRating = null;

    #[ORM\Column(enumType: StatusEnum::class)]
    #[Groups([
        self::GROUP_GET_REVIEW,
        self::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG
    ])]
    #[Assert\NotBlank(message: 'Status cannot be empty.')]
    private ?StatusEnum $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        self::GROUP_GET_REVIEW,
        self::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG
    ])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        self::GROUP_GET_REVIEW,
        self::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG
    ])]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'review', cascade: ['persist'])]
    #[Groups([self::GROUP_GET_REVIEW])]
    private Collection $tag;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'review', cascade: ["remove"])]
    private Collection $comment;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'review')]
    #[Groups([self::GROUP_GET_REVIEW])]
    private Collection $game;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->comment = new ArrayCollection();
        $this->game = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

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

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    #[Groups([
        self::GROUP_GET_REVIEW,
        self::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG
    ])]
    public function getCoverUrl(): ?string
    {
        return $this->cover ? '/uploads/images/review/' . $this->getId() . '/' . $this->cover : null;
    }

    public function getGameRating(): ?int
    {
        return $this->gameRating;
    }

    public function setGameRating(int $gameRating): static
    {
        $this->gameRating = $gameRating;

        return $this;
    }

    public function getStatus(): ?StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): static
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, Tag>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tag->contains($tag)) {
            $this->tag->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tag->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comment->contains($comment)) {
            $this->comment->add($comment);
            $comment->setReview($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comment->removeElement($comment)) {
            if ($comment->getReview() === $this) {
                $comment->setReview(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(Game $game): static
    {
        if (!$this->game->contains($game)) {
            $this->game->add($game);
            $game->addReview($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->game->removeElement($game)) {
            $game->removeReview($this);
        }

        return $this;
    }

//    #[ORM\PreUpdate]
//    public function onPreUpdate(): void
//    {
//        $this->updatedAt = new \DateTime();
//    }
//
//    #[ORM\PrePersist]
//    public function onPrePersist(): void
//    {
//        $this->createdAt = new \DateTime();
//        $this->updatedAt = new \DateTime();
//    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}