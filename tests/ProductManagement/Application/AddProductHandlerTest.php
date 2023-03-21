<?php

declare(strict_types=1);

namespace App\Tests\ProductManagement\Application;

use App\ProductManagement\Application\AddProduct;
use App\ProductManagement\DomainModel\CategoryRepositoryInterface;
use App\ProductManagement\DomainModel\Product;
use App\ProductManagement\Shared\ProductId;
use App\ProductManagement\DomainModel\ProductRepositoryInterface;
use App\ProductManagement\Infrastructure\Persistence\DoctrineCategoryRepository;
use App\ProductManagement\Infrastructure\Persistence\DoctrineProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class AddProductHandlerTest extends KernelTestCase
{
    private ?CategoryRepositoryInterface $categoryRepository = null;
    private ?MessageBusInterface $messageBus;
    private ?ProductRepositoryInterface $productRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->categoryRepository = $container->get(DoctrineCategoryRepository::class);
        $this->productRepository = $container->get(DoctrineProductRepository::class);
        $this->messageBus = $container->get(MessageBusInterface::class);
    }

    public function testAddProduct(): void
    {
        $category = $this->categoryRepository->findByName('Men');

        $productId = ProductId::generate();
        $this->messageBus->dispatch(new AddProduct(
            $productId,
            $category->id,
            'Product 1',
            'Product 1 description',
        ));

        $product = $this->productRepository->get($productId);

        self::assertInstanceOf(Product::class, $product);
    }
}
