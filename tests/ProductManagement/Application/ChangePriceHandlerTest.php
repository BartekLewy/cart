<?php

declare(strict_types=1);

namespace App\Tests\ProductManagement\Application;

use App\ProductManagement\Application\AddProduct;
use App\ProductManagement\Application\ChangeProductPrice;
use App\ProductManagement\DomainModel\CategoryRepositoryInterface;
use App\ProductManagement\Shared\ProductId;
use App\ProductManagement\Infrastructure\Persistence\DoctrineCategoryRepository;
use App\ProductManagement\Infrastructure\Read\DbalProductRepository;
use App\ProductManagement\Shared\CategoryId;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

use function PHPUnit\Framework\assertEquals;

class ChangePriceHandlerTest extends KernelTestCase
{
    private ?CategoryRepositoryInterface $categoryRepository = null;
    private ?MessageBusInterface $messageBus;
    private ?DbalProductRepository $productReadModelRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->categoryRepository = $container->get(DoctrineCategoryRepository::class);
        $this->productReadModelRepository = $container->get(DbalProductRepository::class);
        $this->messageBus = $container->get(MessageBusInterface::class);
    }

    public function testChangeProductPrice(): void
    {
        $productId = ProductId::generate();
        $categoryId = $this->categoryRepository->findByName('Men');
        $this->messageBus->dispatch(new AddProduct(
            $productId,
            $categoryId->id,
            'test2',
            'test2'
        ));

        $this->messageBus->dispatch(new ChangeProductPrice(
            $productId,
            50,
            0.1,
        ));

        $this->assertProductPrice(50, $categoryId->id, $productId);
    }

    private function assertProductPrice(float $expectedPrice, CategoryId $categoryId, ProductId $productId): void
    {
        foreach ($this->productReadModelRepository->getAllByCategoryId($categoryId) as $product) {
            if ($product->id->equals($productId)) {
                assertEquals($expectedPrice, $product->price);
            }
        }
    }
}
