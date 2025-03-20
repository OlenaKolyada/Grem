<?php

namespace App\Entity;

use App\Repository\DeveloperRepository;
use App\Trait\AutoSlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
#[UniqueEntity(fields: ['title'], message: 'Title should be unique.')]
#[UniqueEntity(fields: ['slug'], message: 'Slug should be unique.')]
class Developer
{
    use AutoSlugTrait;
    public const string GROUP_GET_DEVELOPER = 'getDeveloper';
    public const string GROUP_GET_DEVELOPER_COLLECTION = 'getDeveloperCollection';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups([
        self::GROUP_GET_DEVELOPER,
        self::GROUP_GET_DEVELOPER_COLLECTION,
        Game::GROUP_GET_GAME
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups([
        self::GROUP_GET_DEVELOPER,
        self::GROUP_GET_DEVELOPER_COLLECTION,
        Game::GROUP_GET_GAME
    ])]
    #[Assert\NotBlank(message: 'Title cannot be empty')]
    #[Assert\Length(min: 3, max: 255,
        minMessage: 'Title must be at least {{ limit }} characters long',
        maxMessage: 'Title must not exceed {{ limit }} characters')]
    private ?string $title = null;

    #[Groups([
        self::GROUP_GET_DEVELOPER,
        self::GROUP_GET_DEVELOPER_COLLECTION,
        Game::GROUP_GET_GAME
    ])]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Slug cannot be longer than {{ limit }} characters.')]
    private ?string $slug = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Assert\Length(min: 2, max: 255,
        minMessage: 'Country must be at least {{ limit }} characters long',
        maxMessage: 'Country must not exceed {{ limit }} characters')]
    #[Groups([self::GROUP_GET_DEVELOPER])]
    private ?string $country = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Url(message: 'Please provide a valid URL', protocols: ['http', 'https'])]
    #[Groups([self::GROUP_GET_DEVELOPER])]
    private ?string $website = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'developer')]
    #[Groups([self::GROUP_GET_DEVELOPER])]
    private Collection $game;

    public function __construct()
    {
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
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
            $game->addDeveloper($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->game->removeElement($game)) {
            $game->removeDeveloper($this);
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
