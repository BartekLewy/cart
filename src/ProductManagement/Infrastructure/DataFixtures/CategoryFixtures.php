<?php

declare(strict_types=1);

namespace App\ProductManagement\Infrastructure\DataFixtures;

use App\ProductManagement\DomainModel\Category;
use App\ProductManagement\Shared\CategoryId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const KIDS = 'Kids';
    public const WOMEN = 'Women';

    public const MEN = 'Men';

    public function load(ObjectManager $manager): void
    {
        $manager->persist(new Category(CategoryId::generate(), self::KIDS));
        $manager->persist(new Category(CategoryId::generate(), self::WOMEN));
        $manager->persist(new Category(CategoryId::generate(), self::MEN));

        $manager->flush();
    }
}
