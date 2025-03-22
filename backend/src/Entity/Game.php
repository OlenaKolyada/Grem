<?php

namespace App\Entity;

use App\Enum\AgeRatingEnum;
use App\Enum\PlatformRequirementsLevelEnum;
use App\Enum\StatusEnum;
use App\Repository\GameRepository;
use App\Trait\AutoSlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['title'], message: 'Title should be unique.')]
#[UniqueEntity(fields: ['slug'], message: 'Slug should be unique.')]
class Game
{
    use AutoSlugTrait;
    public const string GROUP_GET_GAME = 'getGame';
    public const string GROUP_GET_GAME_COLLECTION = 'getGameCollection';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups([
        self::GROUP_GET_GAME,
        self::GROUP_GET_GAME_COLLECTION,
        News::GROUP_GET_NEWS,
        Review::GROUP_GET_REVIEW,
        Developer::GROUP_GET_DEVELOPER,
        Genre::GROUP_GET_GENRE,
        Publisher::GROUP_GET_PUBLISHER,
        Platform::GROUP_GET_PLATFORM
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Title cannot be empty')]
    #[Assert\Length(max: 255, maxMessage: 'Title must not exceed {{ limit }} characters')]
    #[Groups([
        self::GROUP_GET_GAME,
        self::GROUP_GET_GAME_COLLECTION,
        News::GROUP_GET_NEWS,
        Review::GROUP_GET_REVIEW,
        Developer::GROUP_GET_DEVELOPER,
        Genre::GROUP_GET_GENRE,
        Publisher::GROUP_GET_PUBLISHER,
        Platform::GROUP_GET_PLATFORM
    ])]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING, enumType: StatusEnum::class)]
    #[Groups([
        self::GROUP_GET_GAME,
        self::GROUP_GET_GAME_COLLECTION,
        Developer::GROUP_GET_DEVELOPER,
        Genre::GROUP_GET_GENRE,
        Publisher::GROUP_GET_PUBLISHER,
        Platform::GROUP_GET_PLATFORM,
        News::GROUP_GET_NEWS,
        Review::GROUP_GET_REVIEW
    ])]
    #[Assert\NotBlank(message: 'Status cannot be empty.')]
    private ?StatusEnum $status = null;

    #[Groups([
        self::GROUP_GET_GAME,
        self::GROUP_GET_GAME_COLLECTION,
        News::GROUP_GET_NEWS,
        Review::GROUP_GET_REVIEW,
        Developer::GROUP_GET_DEVELOPER,
        Genre::GROUP_GET_GENRE,
        Publisher::GROUP_GET_PUBLISHER,
        Platform::GROUP_GET_PLATFORM
    ])]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Slug cannot be longer than {{ limit }} characters.')]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Content cannot be blank.')]
    #[Groups([self::GROUP_GET_GAME])]
    #[Assert\Length(min: 10, max: 1000,
        minMessage: 'Content must be at least {{ limit }} characters long.',
        maxMessage: 'Content cannot be longer than {{ limit }} characters.')]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Summary cannot be blank.')]
    #[Groups([
        self::GROUP_GET_GAME,
        self::GROUP_GET_GAME_COLLECTION,
        News::GROUP_GET_NEWS,
        Review::GROUP_GET_REVIEW,
        Developer::GROUP_GET_DEVELOPER,
        Genre::GROUP_GET_GENRE,
        Publisher::GROUP_GET_PUBLISHER,
        Platform::GROUP_GET_PLATFORM,
    ])]
    #[Assert\Length(min: 10,max: 255,
        minMessage: 'Summary must be at least {{ limit }} characters long.',
        maxMessage: 'Summary cannot be longer than {{ limit }} characters.')]
    private ?string $summary = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups([self::GROUP_GET_GAME])]
    private ?\DateTimeInterface $releaseDateWorld = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups([self::GROUP_GET_GAME])]
    private ?\DateTimeInterface $releaseDateFrance = null;

    #[ORM\Column(type: Types::STRING, enumType: PlatformRequirementsLevelEnum::class)]
    #[Groups([self::GROUP_GET_GAME])]
    #[Assert\NotBlank(message: 'Platform requirements level cannot be empty.')]
    private ?PlatformRequirementsLevelEnum $platformRequirementsLevel = null;

    #[ORM\Column(type: Types::STRING, enumType: AgeRatingEnum::class)]
    #[Groups([self::GROUP_GET_GAME])]
    #[Assert\NotBlank(message: 'Age rating cannot be empty.')]
    private ?AgeRatingEnum $ageRating = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'The cover image URL cannot be longer than {{ limit }} characters')]
    private ?string $cover = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    #[Groups([self::GROUP_GET_GAME])]
    #[Assert\All([new Assert\Type(type: Types::STRING, message: 'Each language must be a string.')])]
    private ?array $language = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    #[Groups([self::GROUP_GET_GAME])]
    #[Assert\All([new Assert\Type(type: Types::STRING, message: 'Each screenshot must be a string.'),
        new Assert\Url(message: 'Each screenshot must be a valid URL.')])]
    #[Assert\Count(max: 20, maxMessage: 'You can only upload a maximum of 20 screenshots.')]
    private ?array $screenshot = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Groups([self::GROUP_GET_GAME])]
    #[Assert\Url(message: 'Trailer must be a valid URL.')]
    private ?string $trailer = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Groups([self::GROUP_GET_GAME])]
    #[Assert\NotBlank(message: 'Website URL cannot be blank.')]
    #[Assert\Url(message: 'Website must be a valid URL.')]
    private ?string $website = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        self::GROUP_GET_GAME,
        self::GROUP_GET_GAME_COLLECTION
    ])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        self::GROUP_GET_GAME,
        self::GROUP_GET_GAME_COLLECTION,
        News::GROUP_GET_NEWS,
        Review::GROUP_GET_REVIEW,
        Developer::GROUP_GET_DEVELOPER,
        Genre::GROUP_GET_GENRE,
        Publisher::GROUP_GET_PUBLISHER,
        Platform::GROUP_GET_PLATFORM,
    ])]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, News>
     */
    #[ORM\ManyToMany(targetEntity: News::class, inversedBy: 'game')]
    #[Groups([self::GROUP_GET_GAME])]
    private Collection $news;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\ManyToMany(targetEntity: Review::class, inversedBy: 'game')]
    #[Groups([self::GROUP_GET_GAME])]
    private Collection $review;

    /**
     * @var Collection<int, Developer>
     */
    #[ORM\ManyToMany(targetEntity: Developer::class, inversedBy: 'game')]
    #[Groups([self::GROUP_GET_GAME])]
    private Collection $developer;

    /**
     * @var Collection<int, Publisher>
     */
    #[ORM\ManyToMany(targetEntity: Publisher::class, inversedBy: 'game')]
    #[Groups([self::GROUP_GET_GAME])]
    private Collection $publisher;

    /**
     * @var Collection<int, Genre>
     */
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'game')]
    #[Groups([self::GROUP_GET_GAME])]
    private Collection $genre;

    /**
     * @var Collection<int, Platform>
     */
    #[ORM\ManyToMany(targetEntity: Platform::class, inversedBy: 'game')]
    #[Groups([self::GROUP_GET_GAME])]
    private Collection $platform;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->review = new ArrayCollection();
        $this->developer = new ArrayCollection();
        $this->publisher = new ArrayCollection();
        $this->genre = new ArrayCollection();
        $this->platform = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getReleaseDateWorld(): ?\DateTimeInterface
    {
        return $this->releaseDateWorld;
    }

    public function setReleaseDateWorld(?\DateTimeInterface $releaseDateWorld): static
    {
        $this->releaseDateWorld = $releaseDateWorld;

        return $this;
    }

    public function getReleaseDateFrance(): ?\DateTimeInterface
    {
        return $this->releaseDateFrance;
    }

    public function setReleaseDateFrance(?\DateTimeInterface $releaseDateFrance): static
    {
        $this->releaseDateFrance = $releaseDateFrance;

        return $this;
    }

    public function getPlatformRequirementsLevel(): ?PlatformRequirementsLevelEnum
    {
        return $this->platformRequirementsLevel;
    }

    public function setPlatformRequirementsLevel(PlatformRequirementsLevelEnum $platformRequirementsLevel): static
    {
        $this->platformRequirementsLevel = $platformRequirementsLevel;

        return $this;
    }

    public function getAgeRating(): ?AgeRatingEnum
    {
        return $this->ageRating;
    }

    public function setAgeRating(AgeRatingEnum $ageRating): static
    {
        $this->ageRating = $ageRating;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    #[Groups([
        self::GROUP_GET_GAME,
        self::GROUP_GET_GAME_COLLECTION,
        Developer::GROUP_GET_DEVELOPER,
        News::GROUP_GET_NEWS,
        Review::GROUP_GET_REVIEW,
        Genre::GROUP_GET_GENRE,
        Publisher::GROUP_GET_PUBLISHER,
        Platform::GROUP_GET_PLATFORM,
    ])]
    public function getCoverUrl(): ?string
    {
        return $this->cover ? '/uploads/images/game/' . $this->getId() . '/' . $this->cover : null;
    }

    public function getLanguage(): ?array
    {
        return $this->language;
    }

    public function setLanguage(?array $language): static
    {
        $this->language = $language;

        return $this;
    }


    public function getScreenshot(): ?array
    {
        return $this->screenshot;
    }

    public function setScreenshot(?array $screenshot): static
    {
        $this->screenshot = $screenshot;

        return $this;
    }

    public function getTrailer(): ?string
    {
        return $this->trailer;
    }

    public function setTrailer(?string $trailer): static
    {
        $this->trailer = $trailer;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

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
        }

        return $this;
    }

    public function removeNews(News $news): static
    {
        $this->news->removeElement($news);

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
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        $this->review->removeElement($review);

        return $this;
    }

    /**
     * @return Collection<int, Developer>
     */
    public function getDeveloper(): Collection
    {
        return $this->developer;
    }

    public function addDeveloper(Developer $developer): static
    {
        if (!$this->developer->contains($developer)) {
            $this->developer->add($developer);
        }

        return $this;
    }

    public function removeDeveloper(Developer $developer): static
    {
        $this->developer->removeElement($developer);

        return $this;
    }

    /**
     * @return Collection<int, Publisher>
     */
    public function getPublisher(): Collection
    {
        return $this->publisher;
    }

    public function addPublisher(Publisher $publisher): static
    {
        if (!$this->publisher->contains($publisher)) {
            $this->publisher->add($publisher);
        }

        return $this;
    }

    public function removePublisher(Publisher $publisher): static
    {
        $this->publisher->removeElement($publisher);

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genre->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection<int, Platform>
     */
    public function getPlatform(): Collection
    {
        return $this->platform;
    }

    public function addPlatform(Platform $platform): static
    {
        if (!$this->platform->contains($platform)) {
            $this->platform->add($platform);
        }

        return $this;
    }

    public function removePlatform(Platform $platform): static
    {
        $this->platform->removeElement($platform);

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

    public function __toString(): string
    {
        return $this->title;
    }
}