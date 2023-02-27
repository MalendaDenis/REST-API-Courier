<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    const STATUS_FOR_SHIPPING = 1;
    const STATUS_STARTED = 2;
    const STATUS_DELIVERED = 3;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?float $order_price = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $customer_name = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 15)]
    private ?string $phone = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 10)]
    private ?string $secret_word = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private int $status = self::STATUS_FOR_SHIPPING;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Courier $courier = null;


    public function __construct(Location $location, string $order_price,
                                string $customer_name, string $phone,
                                string $address, string $secret_word)
    {
        $this->location = $location;
        $this->order_price = $order_price;
        $this->customer_name = $customer_name;
        $this->phone = $phone;
        $this->address = $address;
        $this->secret_word = $secret_word;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOrderPrice(): ?float
    {
        return $this->order_price;
    }

    public function setOrderPrice(float $order_price): self
    {
        $this->order_price = $order_price;

        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->customer_name;
    }

    public function setCustomerName(string $customer_name): self
    {
        $this->customer_name = $customer_name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSecretWord(): ?string
    {
        return $this->secret_word;
    }

    public function setSecretWord(string $secret_word): self
    {
        $this->secret_word = $secret_word;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCourier(): ?Courier
    {
        return $this->courier;
    }

    public function setCourier(?Courier $courier): self
    {
        $this->courier = $courier;

        return $this;
    }
}
