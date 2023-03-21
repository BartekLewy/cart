<?php

declare(strict_types=1);

namespace App\Tests\Cart\DomainModel;

use App\Cart\DomainModel\Product;
use App\Cart\DomainModel\ProductRepositoryInterface;
use App\Cart\Shared\ProductId;

class InMemoryProductRepository implements ProductRepositoryInterface
{
    private array $products = [];

    public function save(Product $product): void
    {
        $this->products[$product->id()->id()] = $product;
    }

    public function get(ProductId $productId): Product
    {
        return $this->products[$productId->id()];
    }

    public function clear(): void
    {
        $this->products = [];
    }
}
