<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->orderdetail = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="The name should not be blank !"
     * )
     * @Assert\Length(
     *      max = 25,
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Assert\Positive(
     *     message="The value of the price field is invalid !"
     * )
     * @Assert\NotBlank(
     *     message="The price should not be blank !"
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     *     message="The quantity should not be blank !"
     * )
     * @Assert\Range(
     *      min = 10,
     *      max = 10000,
     *      minMessage = "Quantity must be at least {{ limit }} unit",
     *      maxMessage = "Quantity cannot be taller than {{ limit }} unit",
     *      notInRangeMessage="Quantity value should be between 10 and 10000."
     * )
     */
    private $quantity;

    /**
     * @ORM\Column(type="text")
     * * @Assert\NotBlank(
     *     message="The description should not be blank !"
     * )
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageURL;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderDetail", mappedBy="product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $orderdetail;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImageURL(): ?string
    {
        return $this->imageURL;
    }

    public function setImageURL(string $imageURL): self
    {
        $this->imageURL = $imageURL;

        return $this;
    }

    public function getLastProduct(){

    }

    public function getOrderdetail(): ?OrderDetail
    {
        return $this->orderdetail;
    }

    public function setOrderdetail(?OrderDetail $orderdetail): self
    {
        $this->orderdetail = $orderdetail;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function addOrderdetail(OrderDetail $orderdetail): self
    {
        if (!$this->orderdetail->contains($orderdetail)) {
            $this->orderdetail[] = $orderdetail;
            $orderdetail->setProduct($this);
        }

        return $this;
    }

    public function removeOrderdetail(OrderDetail $orderdetail): self
    {
        if ($this->orderdetail->contains($orderdetail)) {
            $this->orderdetail->removeElement($orderdetail);
            // set the owning side to null (unless already changed)
            if ($orderdetail->getProduct() === $this) {
                $orderdetail->setProduct(null);
            }
        }

        return $this;
    }
}
