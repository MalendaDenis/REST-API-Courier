<?php

namespace App\Entity;

use App\Repository\LocationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationsRepository::class)]
#[ORM\Table(name: '`location`')]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 12)]
    private ?int $shippingCost = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Order::class)]
    private Collection $orders;


    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Courier::class)]
    private Collection $couriers;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->couriers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getShippingCost(): ?int
    {
        return $this->shippingCost;
    }

    public function setShippingCost(float $shippingCost): self
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }


    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setLocation($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getLocation() === $this) {
                $order->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Courier>
     */
    public function getCouriers(): Collection
    {
        return $this->couriers;
    }

    public function addCourier(Courier $courier): self
    {
        if (!$this->couriers->contains($courier)) {
            $this->couriers->add($courier);
            $courier->setLocation($this);
        }

        return $this;
    }

    public function removeCourier(Courier $courier): self
    {
        if ($this->couriers->removeElement($courier)) {
            // set the owning side to null (unless already changed)
            if ($courier->getLocation() === $this) {
                $courier->setLocation(null);
            }
        }

        return $this;
    }

}
