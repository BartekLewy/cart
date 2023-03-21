<?php

declare(strict_types=1);

namespace App\Cart\DomainModel;

use App\Cart\Shared\ProductId;

interface ProductRepositoryInterface
{
    public function get(ProductId $productId): Product;
}
