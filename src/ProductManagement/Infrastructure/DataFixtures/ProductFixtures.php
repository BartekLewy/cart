<?php

declare(strict_types=1);

namespace App\ProductManagement\Infrastructure\DataFixtures;

use App\ProductManagement\DomainModel\CategoryRepositoryInterface;
use App\ProductManagement\DomainModel\Currency;
use App\ProductManagement\DomainModel\Price;
use App\ProductManagement\DomainModel\Product;
use App\ProductManagement\DomainModel\ProductDescription;
use App\ProductManagement\Shared\ProductId;
use App\ProductManagement\DomainModel\ProductName;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->products() as $product) {
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }

    private function products(): array
    {
        return [
            new Product(
                new ProductId('00000000-0000-0000-0000-000000000000'),
                new ProductName('Skarpetki dziecięce Myszka Miki'),
                new ProductDescription('Skarpetki dziecięce rozmiar 26-28'),
                $this->categoryRepository->findByName(CategoryFixtures::KIDS),
                new Price(18.69, 0.07, Currency::PLN),
            ),
            new Product(
                new ProductId('00000000-0000-0000-0000-000000000001'),
                new ProductName('Skarpety męskie czarne'),
                new ProductDescription('Skarpety męskie czarne rozmiar, 44-46'),
                $this->categoryRepository->findByName(CategoryFixtures::MEN),
                new Price(27.10, 0.07, Currency::PLN),
            ),
            new Product(
                new ProductId('00000000-0000-0000-0000-000000000002'),
                new ProductName('Skarpety męskie białe'),
                new ProductDescription('Skarpety męskie białe, rozmiar 44-46'),
                $this->categoryRepository->findByName(CategoryFixtures::MEN),
                new Price(31.77, 0.07, Currency::PLN),
            ),
            new Product(
                new ProductId('00000000-0000-0000-0000-000000000003'),
                new ProductName('Skarpety damskie szare'),
                new ProductDescription('Skarpety damskie szare, rozmiar 35-38'),
                $this->categoryRepository->findByName(CategoryFixtures::WOMEN),
                new Price(28.03, 0.07, Currency::PLN),
            ),
            new Product(
                new ProductId('00000000-0000-0000-0000-000000000004'),
                new ProductName('Skarpety damskie szare - długie'),
                new ProductDescription('Skarpety damskie szare, długie rozmiar 35-38'),
                $this->categoryRepository->findByName(CategoryFixtures::WOMEN),
                new Price(37.37, 0.07, Currency::PLN),
            ),
        ];
    }
}
