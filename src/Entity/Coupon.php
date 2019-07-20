<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CouponRepository")
 */
class Coupon extends Entity
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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validFrom;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validTo;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="coupons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $redeemCount = 0;

    public function toArray()
    {
        return parent::toArray() + [
            'name' => $this->name,
            'description' => $this->description,
            'code' => $this->code,
            'validFrom' => $this->validFrom,
            'validTo' => $this->validTo,
            'redeemCount' => $this->redeemCount,
        ];
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getValidFrom(): ?DateTime
    {
        return $this->validFrom;
    }

    public function setValidFrom(?DateTime $validFrom): void
    {
        $this->validFrom = $validFrom;
    }

    public function getValidTo(): ?DateTime
    {
        return $this->validTo;
    }

    public function setValidTo(?DateTime $validTo): void
    {
        $this->validTo = $validTo;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): void
    {
        $this->brand = $brand;
    }

    public function getRedeemCount(): int
    {
        return $this->redeemCount;
    }

    public function setRedeemCount(int $redeemCount): void
    {
        $this->redeemCount = $redeemCount;
    }

    public function incrementRedeemCount(int $quantity = 1): void
    {
        $this->redeemCount += $quantity;
    }
}
