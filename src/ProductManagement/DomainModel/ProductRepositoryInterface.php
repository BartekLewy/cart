<?php

declare(strict_types=1);

namespace App\ProductManagement\DomainModel;

use App\ProductManagement\Shared\ProductId;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;

    public function get(ProductId $productId): Product;
}
