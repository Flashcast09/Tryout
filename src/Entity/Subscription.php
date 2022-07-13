<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Name;

    #[ORM\Column(type: 'integer')]
    private $Price;

    #[ORM\Column(type: 'string', length: 255)]
    private $Duration;

    #[ORM\Column(type: 'integer')]
    private $Discount;

    #[ORM\OneToMany(mappedBy: 'subscription', targetEntity: Users::class)]
    private $Users_Sub;

    public function __construct()
    {
        $this->Users_Sub = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(int $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->Duration;
    }

    public function setDuration(string $Duration): self
    {
        $this->Duration = $Duration;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->Discount;
    }

    public function setDiscount(int $Discount): self
    {
        $this->Discount = $Discount;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsersSub(): Collection
    {
        return $this->Users_Sub;
    }

    public function addUsersSub(Users $usersSub): self
    {
        if (!$this->Users_Sub->contains($usersSub)) {
            $this->Users_Sub[] = $usersSub;
            $usersSub->setSubscription($this);
        }

        return $this;
    }

    public function removeUsersSub(Users $usersSub): self
    {
        if ($this->Users_Sub->removeElement($usersSub)) {
            // set the owning side to null (unless already changed)
            if ($usersSub->getSubscription() === $this) {
                $usersSub->setSubscription(null);
            }
        }

        return $this;
    }
}
