<?php

namespace App\Repository;

use App\Entity\BrandCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BrandCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BrandCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BrandCategory[]    findAll()
 * @method BrandCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BrandCategory::class);
    }

    public function findByNameLike(string $name)
    {
        return $this->createQueryBuilder('brand_category')
            ->where('brand_category.name LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->getQuery()
            ->getResult();
    }
}
