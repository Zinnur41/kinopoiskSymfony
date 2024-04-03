<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    private ?string $secondName = null;

    #[ORM\Column(length: 100)]
    private ?string $thirdName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdayDate = null;

    #[ORM\OneToMany(mappedBy: 'reviewer', targetEntity: Feedback::class, orphanRemoval: true)]
    private Collection $feedback;

    #[ORM\OneToMany(mappedBy: 'reviewer', targetEntity: SiteFeedback::class, orphanRemoval: true)]
    private Collection $siteFeedback;

    #[ORM\ManyToMany(targetEntity: Film::class, inversedBy: 'users')]
    private Collection $favoriteFilms;

    #[ORM\ManyToOne(inversedBy: 'account')]
    private ?Subscribe $subscribe = null;

    public function __construct()
    {
        $this->feedback = new ArrayCollection();
        $this->siteFeedback = new ArrayCollection();
        $this->favoriteFilms = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function setSecondName(string $secondName): static
    {
        $this->secondName = $secondName;

        return $this;
    }

    public function getThirdName(): ?string
    {
        return $this->thirdName;
    }

    public function setThirdName(string $thirdName): static
    {
        $this->thirdName = $thirdName;

        return $this;
    }

    public function getBirthdayDate(): ?\DateTimeInterface
    {
        return $this->birthdayDate;
    }

    public function setBirthdayDate(\DateTimeInterface $birthdayDate): static
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getFeedback(): Collection
    {
        return $this->feedback;
    }

    public function addFeedback(Feedback $feedback): static
    {
        if (!$this->feedback->contains($feedback)) {
            $this->feedback->add($feedback);
            $feedback->setReviewer($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): static
    {
        if ($this->feedback->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getReviewer() === $this) {
                $feedback->setReviewer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SiteFeedback>
     */
    public function getSiteFeedback(): Collection
    {
        return $this->siteFeedback;
    }

    public function addSiteFeedback(SiteFeedback $siteFeedback): static
    {
        if (!$this->siteFeedback->contains($siteFeedback)) {
            $this->siteFeedback->add($siteFeedback);
            $siteFeedback->setReviewer($this);
        }

        return $this;
    }

    public function removeSiteFeedback(SiteFeedback $siteFeedback): static
    {
        if ($this->siteFeedback->removeElement($siteFeedback)) {
            // set the owning side to null (unless already changed)
            if ($siteFeedback->getReviewer() === $this) {
                $siteFeedback->setReviewer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Film>
     */
    public function getFavoriteFilms(): Collection
    {
        return $this->favoriteFilms;
    }

    public function addFavoriteFilm(Film $favoriteFilm): static
    {
        if (!$this->favoriteFilms->contains($favoriteFilm)) {
            $this->favoriteFilms->add($favoriteFilm);
        }

        return $this;
    }

    public function removeFavoriteFilm(Film $favoriteFilm): static
    {
        $this->favoriteFilms->removeElement($favoriteFilm);

        return $this;
    }

    public function getSubscribe(): ?Subscribe
    {
        return $this->subscribe;
    }

    public function setSubscribe(?Subscribe $subscribe): static
    {
        $this->subscribe = $subscribe;

        return $this;
    }

}
