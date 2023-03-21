<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Read;

use App\Cart\ReadModel\Product;
use App\Cart\ReadModel\ProductRepositoryInterface;
use App\Cart\Shared\ProductId;
use Doctrine\DBAL\Connection;

class DbalProductRepository implements ProductRepositoryInterface
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /** @return Product[] */
    public function getAll(): array
    {
        $products = $this
            ->connection
            ->createQueryBuilder()
            ->select('id', 'name', 'description', 'price', 'vat_rate')
            ->from('products')
            ->executeQuery()
            ->fetchAllAssociative()
        ;

        return array_map(fn (array $product) => new Product(
            new ProductId($product['id']),
            $product['name'],
            $product['description'],
            $product['price'],
            $product['vat_rate'],
        ), $products);
    }
}
