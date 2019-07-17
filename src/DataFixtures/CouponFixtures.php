<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Coupon;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CouponFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $brands = $manager->getRepository(Brand::class)->findAll();

        for ($i = 0; $i < 100; $i++) {
            $coupon = new Coupon();

            $coupon->setName($this->faker->sentence(4));
            $coupon->setDescription($this->faker->sentence(16));
            $coupon->setCode($this->faker->asciify(str_repeat('*', $this->faker->numberBetween(5, 12))));
            $coupon->setValidFrom($this->faker->optional()->dateTimeBetween('-1 week', '+2 weeks'));
            $coupon->setBrand($this->faker->randomElement($brands));

            if ($from = $coupon->getValidFrom()) {
                $coupon->setValidTo(
                    $this->faker->optional()->dateTimeBetween($from, $from->modify('+2 weeks'))
                );
            }

            $manager->persist($coupon);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencies()
    {
        return [
            BrandFixtures::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getGroups(): array
    {
        return [
            'coupons',
        ];
    }
}
