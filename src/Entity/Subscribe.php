<?php

namespace App\Entity;

use App\Repository\SubscribeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscribeRepository::class)]
class Subscribe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'subscribe', targetEntity: User::class)]
    private Collection $account;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    public function __construct()
    {
        $this->account = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getAccount(): Collection
    {
        return $this->account;
    }

    public function addAccount(User $account): static
    {
        if (!$this->account->contains($account)) {
            $this->account->add($account);
            $account->setSubscribe($this);
        }

        return $this;
    }

    public function removeAccount(User $account): static
    {
        if ($this->account->removeElement($account)) {
            // set the owning side to null (unless already changed)
            if ($account->getSubscribe() === $this) {
                $account->setSubscribe(null);
            }
        }

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }
}
