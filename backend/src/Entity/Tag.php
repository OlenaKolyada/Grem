<?php

namespace App\Entity;

use App\Repository\TagRepository;
use App\Trait\AutoSlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TagRepository::class)]
#[UniqueEntity(fields: ['title'], message: 'Title should be unique.')]
#[UniqueEntity(fields: ['slug'], message: 'Slug should be unique.')]
class Tag
{
    use AutoSlugTrait;
    public const string GROUP_GET_TAG = 'getTag';
    public const string GROUP_GET_TAG_COLLECTION = 'getTagCollection';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups([
        self::GROUP_GET_TAG,
        self::GROUP_GET_TAG_COLLECTION,
        News::GROUP_GET_NEWS,
        Review::GROUP_GET_REVIEW
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([
        self::GROUP_GET_TAG,
        self::GROUP_GET_TAG_COLLECTION,
        News::GROUP_GET_NEWS,
        Review::GROUP_GET_REVIEW
    ])]
    #[Assert\NotBlank(message: 'Title cannot be empty')]
    #[Assert\Length(min: 3, max: 255,
        minMessage: 'Title must be at least {{ limit }} characters long',
        maxMessage: 'Title must not exceed {{ limit }} characters')]
    private ?string $title = null;

    #[Groups([
        self::GROUP_GET_TAG,
        self::GROUP_GET_TAG_COLLECTION,
        News::GROUP_GET_NEWS,
        Review::GROUP_GET_REVIEW
    ])]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Slug cannot be longer than {{ limit }} characters.')]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, News>
     */
    #[ORM\ManyToMany(targetEntity: News::class, mappedBy: 'tag')]
    #[Groups([self::GROUP_GET_TAG])]
    private Collection $news;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\ManyToMany(targetEntity: Review::class, mappedBy: 'tag')]
    #[Groups([self::GROUP_GET_TAG])]
    private Collection $review;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->review = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, News>
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): static
    {
        if (!$this->news->contains($news)) {
            $this->news->add($news);
            $news->addTag($this);
        }

        return $this;
    }

    public function removeNews(News $news): static
    {
        if ($this->news->removeElement($news)) {
            $news->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReview(): Collection
    {
        return $this->review;
    }

    public function addReview(Review $review): static
    {
        if (!$this->review->contains($review)) {
            $this->review->add($review);
            $review->addTag($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->review->removeElement($review)) {
            $review->removeTag($this);
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

    public function __toString(): string
    {
        return $this->title;
    }
}