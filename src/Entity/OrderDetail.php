<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderDetailRepository")
 */
class OrderDetail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="orderdetail")
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="orderDetail")
     */
    private $orderProduct;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->orderProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->setOrderdetail($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->product->contains($product)) {
            $this->product->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getOrderdetail() === $this) {
                $product->setOrderdetail(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrderProduct(): Collection
    {
        return $this->orderProduct;
    }

    public function addOrderProduct(Order $orderProduct): self
    {
        if (!$this->orderProduct->contains($orderProduct)) {
            $this->orderProduct[] = $orderProduct;
            $orderProduct->setOrderDetail($this);
        }

        return $this;
    }

    public function removeOrderProduct(Order $orderProduct): self
    {
        if ($this->orderProduct->contains($orderProduct)) {
            $this->orderProduct->removeElement($orderProduct);
            // set the owning side to null (unless already changed)
            if ($orderProduct->getOrderDetail() === $this) {
                $orderProduct->setOrderDetail(null);
            }
        }

        return $this;
    }
}
