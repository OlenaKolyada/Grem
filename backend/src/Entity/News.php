<?php

namespace App\Entity;

use App\Enum\StatusEnum;
use App\Repository\NewsRepository;
use App\Trait\AutoSlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['title'], message: 'Title should be unique.')]
#[UniqueEntity(fields: ['slug'], message: 'Slug should be unique.')]
class News
{
    use AutoSlugTrait;
    public const string GROUP_GET_NEWS = 'getNews';
    public const string GROUP_GET_NEWS_COLLECTION = 'getNewsCollection';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups([self::GROUP_GET_NEWS, self::GROUP_GET_NEWS_COLLECTION, Game::GROUP_GET_GAME, Tag::GROUP_GET_TAG])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([self::GROUP_GET_NEWS, self::GROUP_GET_NEWS_COLLECTION, Game::GROUP_GET_GAME, Tag::GROUP_GET_TAG])]
    #[Assert\NotBlank(message: 'Title cannot be empty')]
    #[Assert\Length(min: 3, max: 255,
        minMessage: 'Title must be at least {{ limit }} characters long',
        maxMessage: 'Title must not exceed {{ limit }} characters')]
    private ?string $title = null;

    #[Groups([self::GROUP_GET_NEWS, self::GROUP_GET_NEWS_COLLECTION, Game::GROUP_GET_GAME, Tag::GROUP_GET_TAG])]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Slug cannot be longer than {{ limit }} characters.')]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups([self::GROUP_GET_NEWS])]
    #[Assert\NotBlank(message: 'Content cannot be empty')]
    #[Assert\Length(min: 10, max: 1000,
        minMessage: 'Content must be at least {{ limit }} characters long.',
        maxMessage: 'Content cannot be longer than {{ limit }} characters.')]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups([self::GROUP_GET_NEWS, self::GROUP_GET_NEWS_COLLECTION, Game::GROUP_GET_GAME, Tag::GROUP_GET_TAG])]
    #[Assert\NotBlank(message: 'Summary cannot be empty')]
    #[Assert\Length(min: 10,max: 255,
        minMessage: 'Summary must be at least {{ limit }} characters long.',
        maxMessage: 'Summary cannot be longer than {{ limit }} characters.')]
    private ?string $summary = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'The cover image URL cannot be longer than {{ limit }} characters')]
    private ?string $cover = null;

    #[ORM\Column(type: Types::STRING, enumType: StatusEnum::class)]
    #[Groups([self::GROUP_GET_NEWS, self::GROUP_GET_NEWS_COLLECTION, Game::GROUP_GET_GAME, Tag::GROUP_GET_TAG])]
    #[Assert\NotBlank(message: 'Status cannot be empty.')]
    private ?StatusEnum $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([self::GROUP_GET_NEWS, self::GROUP_GET_NEWS_COLLECTION, Game::GROUP_GET_GAME, Tag::GROUP_GET_TAG])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([self::GROUP_GET_NEWS, self::GROUP_GET_NEWS_COLLECTION, Game::GROUP_GET_GAME, Tag::GROUP_GET_TAG])]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'news', cascade: ['persist'])]
    #[Groups([self::GROUP_GET_NEWS])]
    private Collection $tag;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'news')]
    #[Groups([self::GROUP_GET_NEWS])]
    private Collection $game;

    #[ORM\ManyToOne(inversedBy: 'news')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    #[Groups([self::GROUP_GET_NEWS, self::GROUP_GET_NEWS_COLLECTION, Game::GROUP_GET_GAME, Tag::GROUP_GET_TAG])]
    private ?User $author = null;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
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

    #[Groups([self::GROUP_GET_NEWS, self::GROUP_GET_NEWS_COLLECTION, Game::GROUP_GET_GAME, Tag::GROUP_GET_TAG])]
    public function getCoverUrl(): ?string
    {
        return $this->cover ? '/uploads/images/news/' . $this->getId() . '/' . $this->cover : null;
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

    public function setTag(Collection $tag): static
    {

        foreach ($tag as $tagItem) {
            $this->addTag($tagItem);
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
            $game->addNews($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->game->removeElement($game)) {
            $game->removeNews($this);
        }

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

//    public function setCreatedAt(\DateTimeInterface $createdAt): static
//    {
//        $this->createdAt = $createdAt;
//
//        return $this;
//    }
//
//    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
//    {
//        $this->updatedAt = $updatedAt;
//
//        return $this;
//    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}