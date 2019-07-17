<?php

namespace App\DataFixtures;

use App\Entity\BrandCategory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BrandCategoryFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $category = new BrandCategory();

            $category->setName($this->faker->company);

            $manager->persist($category);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public static function getGroups(): array
    {
        return [
            'brands',
            'coupons',
        ];
    }
}
