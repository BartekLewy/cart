<?php

declare(strict_types=1);

namespace App\ProductManagement\Application;

use App\ProductManagement\Shared\ProductId;
use App\ProductManagement\Shared\CategoryId;

class AddProduct
{
    public function __construct(
        public readonly ProductId $productId,
        public readonly CategoryId $categoryId,
        public readonly string $name,
        public readonly string $description,
    ) {
    }
}
