<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="order_product")
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->orderDetail = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderDetail", mappedBy="orderProduct")
     * @ORM\JoinColumn(nullable=true)
     */
    private $orderDetail;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDetail(): ?OrderDetail
    {
        return $this->orderDetail;
    }

    public function setOrderDetail(?OrderDetail $orderDetail): self
    {
        $this->orderDetail = $orderDetail;

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

    public function addOrderDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetail->contains($orderDetail)) {
            $this->orderDetail[] = $orderDetail;
            $orderDetail->setOrderProduct($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): self
    {
        if ($this->orderDetail->contains($orderDetail)) {
            $this->orderDetail->removeElement($orderDetail);
            // set the owning side to null (unless already changed)
            if ($orderDetail->getOrderProduct() === $this) {
                $orderDetail->setOrderProduct(null);
            }
        }

        return $this;
    }
}
