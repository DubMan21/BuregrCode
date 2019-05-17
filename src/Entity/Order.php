<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $order_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderProduct", mappedBy="theOrder", orphanRemoval=true)
     */
    private $orderProducts;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderAt(): ?\DateTimeInterface
    {
        return $this->order_at;
    }

    public function setOrderAt(\DateTimeInterface $order_at): self
    {
        $this->order_at = $order_at;

        return $this;
    }

    /**
     * @return Collection|OrderProduct[]
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    /**
     * @return OrderProduct
     */
    public function getOrderProductByIndex(int $i)
    {
        return $this->orderProducts[$i];
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setTheOrder($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->removeElement($orderProduct);
            // set the owning side to null (unless already changed)
            if ($orderProduct->getTheOrder() === $this) {
                $orderProduct->setTheOrder(null);
            }
        }

        return $this;
    }

    public function totalPrice()
    {
        $total = 0;

        foreach($this->getOrderProducts() as $item)
        {
            $price = $item->getQuantity() * $item->getProduct()->getPrice();
            $total += $price;
        }

        return $total;
    }
}
