<?php

namespace App\Repository;

use App\Entity\Coupon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Coupon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coupon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coupon[]    findAll()
 * @method Coupon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouponRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    public function createSearchQueryBuilder(int $page = 1, ?string $query = null, ?string $category = null)
    {
        $qb = $this->createQueryBuilder('coupon')
            ->leftJoin('coupon.brand', 'brand')
            ->leftJoin('brand.category', 'brand_category')
            ->setFirstResult(10 * ($page - 1))
            ->setMaxResults(10);

        if ($category) {
            $qb->andWhere($qb->expr()->eq('brand_category.id', ':category'))
                ->setParameter('category', $category);
        }

        if ($query) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('coupon.name', ':query'),
                    $qb->expr()->like('brand.name', ':query'),
                    $qb->expr()->like('brand_category.name', ':query')
                )
            )
                ->setParameter('query', '%' . $query . '%');
        }

        return $qb;
    }

    public function createSearchPaginator(int $page = 1, ?string $query = null, ?string $category = null)
    {
        return new Paginator($this->createSearchQueryBuilder($page, $query, $category));
    }
}
