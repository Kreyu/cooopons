<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\BrandCategory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BrandFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $categories = $manager->getRepository(BrandCategory::class)->findAll();

        for ($i = 0; $i < 25; $i++) {
            $brand = new Brand();

            $brand->setName($this->faker->company);
            $brand->setDescription($this->faker->sentence(16));
            $brand->setCategory($this->faker->randomElement($categories));

            $manager->persist($brand);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencies()
    {
        return [
            BrandCategoryFixtures::class,
        ];
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
