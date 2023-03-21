<?php

declare(strict_types=1);

namespace App\ProductManagement\Infrastructure\Read;

use App\ProductManagement\Shared\ProductId;
use App\ProductManagement\ReadModel\Product;
use App\ProductManagement\ReadModel\ProductRepositoryInterface;
use App\ProductManagement\Shared\CategoryId;
use Doctrine\DBAL\Connection;

class DbalProductRepository implements ProductRepositoryInterface
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function getAll(): array
    {
        $products = $this->connection
            ->createQueryBuilder()
            ->select('id', 'name', 'description', 'price', 'vat_rate')
            ->from('products')
            ->executeQuery()
            ->fetchAllAssociative();

        return $this->mapProducts($products);
    }

    public function getAllByCategoryId(CategoryId $categoryId): array
    {
        $products = $this->connection
            ->createQueryBuilder()
            ->select('id', 'name', 'description', 'price', 'vat_rate')
            ->from('products')
            ->where('category_id = :category_id')
            ->setParameters([
                'category_id' => $categoryId->id(),
            ])
            ->executeQuery()
            ->fetchAllAssociative();

        return $this->mapProducts($products);
    }

    private function mapProducts(array $products): array
    {
        return array_map(fn (array $product): Product => $this->mapProduct($product), $products);
    }

    private function mapProduct(array $product): Product
    {
        return new Product(
            new ProductId($product['id']),
            $product['name'],
            $product['description'],
            $product['price'],
            $product['vat_rate'],
        );
    }
}
