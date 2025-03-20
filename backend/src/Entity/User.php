<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\UniqueEmail;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\UniqueConstraint(name: 'UNIQ_USER_NICKNAME', fields: ['nickname'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const string GROUP_GET_USER = 'getUser';
    public const string GROUP_GET_USER_COLLECTION = 'getUserCollection';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups([
        self::GROUP_GET_USER,
        self::GROUP_GET_USER_COLLECTION,
        News::GROUP_GET_NEWS,
        News::GROUP_GET_NEWS_COLLECTION,
        Review::GROUP_GET_REVIEW,
        Review::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG,
        Comment::GROUP_GET_COMMENT,
        Comment::GROUP_GET_COMMENT_COLLECTION
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Email cannot be blank.')]
    #[Assert\Email(message: 'Please provide a valid email address.')]
    #[Assert\Length(max: 255, maxMessage: 'Email cannot be longer than {{ limit }} characters.')]
    #[UniqueEmail(groups: ['registration'])]
    #[Groups([self::GROUP_GET_USER])]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank(message: 'Password cannot be blank.')]
    #[Assert\Length(min: 8, max: 255,
        minMessage: 'Password must be at least {{ limit }} characters long.',
        maxMessage: 'Password cannot be longer than {{ limit }} characters.')]
    private ?string $password = null;

    #[ORM\Column(type: Types::JSON)]
    #[Groups([
        self::GROUP_GET_USER,
        self::GROUP_GET_USER_COLLECTION
    ])]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3, max: 255,
        minMessage: 'Nickname must be at least {{ limit }} characters long.',
        maxMessage: 'Nickname cannot be longer than {{ limit }} characters.')]
    #[Assert\NotBlank(message: 'Nickname cannot be blank.')]
    #[Groups([
        self::GROUP_GET_USER,
        self::GROUP_GET_USER_COLLECTION,
        News::GROUP_GET_NEWS,
        News::GROUP_GET_NEWS_COLLECTION,
        Review::GROUP_GET_REVIEW,
        Review::GROUP_GET_REVIEW_COLLECTION,
        Game::GROUP_GET_GAME,
        Tag::GROUP_GET_TAG,
        Comment::GROUP_GET_COMMENT,
        Comment::GROUP_GET_COMMENT_COLLECTION
    ])]
    private ?string $nickname = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Groups([self::GROUP_GET_USER])]
    private ?string $twitchAccount = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $avatar = null;

    /**
     * @var Collection<int, News>
     */
    #[ORM\OneToMany(targetEntity: News::class, mappedBy: 'author')]
    private Collection $news;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'author')]
    private Collection $review;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'author', cascade: ['persist'])]
    private Collection $comment;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        self::GROUP_GET_USER
    ])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        self::GROUP_GET_USER
    ])]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, UserToken>
     */
    #[ORM\OneToMany(targetEntity: UserToken::class, mappedBy: 'user')]
    private Collection $userTokens;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->news = new ArrayCollection();
        $this->review = new ArrayCollection();
        $this->comment = new ArrayCollection();
        $this->userTokens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        if ($password !== null) {
            $this->password = $password;
        }
        return $this;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nickname;
    }

    public function getTwitchAccount(): ?string
    {
        return $this->twitchAccount;
    }

    public function setTwitchAccount(?string $twitchAccount): static
    {
        $this->twitchAccount = $twitchAccount;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    #[Groups([
        self::GROUP_GET_USER,
        self::GROUP_GET_USER_COLLECTION
    ])]
    public function getAvatarUrl(): ?string
    {
        return $this->avatar ? '/uploads/images/user/' . $this->getId() . '/' . $this->avatar : null;
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
            $news->setAuthor($this);
        }

        return $this;
    }

    public function removeNews(News $news): static
    {
        if ($this->news->removeElement($news)) {
            if ($news->getAuthor() === $this) {
                $news->setAuthor(null);
            }
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
            $review->setAuthor($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->review->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getAuthor() === $this) {
                $review->setAuthor(null);
            }
        }

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
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comment->removeElement($comment)) {

            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

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

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    /**
     * @return Collection<int, UserToken>
     */
    public function getUserTokens(): Collection
    {
        return $this->userTokens;
    }

    public function addUserToken(UserToken $userToken): static
    {
        if (!$this->userTokens->contains($userToken)) {
            $this->userTokens->add($userToken);
            $userToken->setUser($this);
        }

        return $this;
    }

    public function removeUserToken(UserToken $userToken): static
    {
        if ($this->userTokens->removeElement($userToken)) {
            // set the owning side to null (unless already changed)
            if ($userToken->getUser() === $this) {
                $userToken->setUser(null);
            }
        }

        return $this;
    }
}
