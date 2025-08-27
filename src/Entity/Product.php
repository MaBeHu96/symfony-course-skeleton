<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Index(name: 'IDX_product_sku', columns: ['sku'])]
#[ORM\Index(name: 'IDX_product_price', columns: ['price'])]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', columnDefinition: 'CHAR(36) NOT NULL')]
    private string $id;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Product name has to be at least {{ limit }} characters',
        maxMessage: 'Product name has to be maximun {{ limit }} characters',
    )]
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $name;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Product name has to be at least {{ limit }} characters',
        maxMessage: 'Product name has to be maximun {{ limit }} characters',
    )]
    #[ORM\Column(type: 'string',length: 50)]
    private ?string $sku;

    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[ORM\Column(type: 'integer')]
    private ?int $price;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdOn;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category;

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->createdOn = new DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedOn(): \DateTimeInterface
    {
        return $this->createdOn;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
