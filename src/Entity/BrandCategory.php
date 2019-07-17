<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandCategoryRepository")
 */
class BrandCategory extends Entity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var Collection|Brand[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Brand", mappedBy="category")
     */
    private $brands;

    public function __construct()
    {
        $this->brands = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBrands()
    {
        return $this->brands;
    }

    public function addBrand(Brand $brand): void
    {
        if (!$this->brands->contains($brand)) {
            $brand->setCategory($this);
            $this->brands->add($brand);
        }
    }

    public function removeBrand(Brand $brand): void
    {
        if ($this->brands->contains($brand)) {
            $this->brands->removeElement($brand);

            if ($brand->getCategory() === $this) {
                $brand->setCategory(null);
            }
        }
    }
}
