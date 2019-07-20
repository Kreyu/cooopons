<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 */
class Brand extends Entity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var BrandCategory|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\BrandCategory", inversedBy="brands")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @var Collection|Coupon[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Coupon", mappedBy="brand")
     */
    private $coupons;

    public function __construct()
    {
        $this->coupons = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCategory(): ?BrandCategory
    {
        return $this->category;
    }

    public function setCategory(?BrandCategory $category): void
    {
        $this->category = $category;
    }

    public function getCoupons()
    {
        return $this->coupons;
    }

    public function addCoupon(Coupon $coupon): void
    {
        if (!$this->coupons->contains($coupon)) {
            $coupon->setBrand($this);
            $this->coupons->add($coupon);
        }
    }

    public function removeCoupon(Coupon $coupon): void
    {
        if ($this->coupons->contains($coupon)) {
            $this->coupons->removeElement($coupon);

            if ($coupon->getBrand() === $this) {
                $coupon->setBrand(null);
            }
        }
    }
}
