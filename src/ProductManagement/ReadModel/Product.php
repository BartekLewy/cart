<?php

declare(strict_types=1);

namespace App\ProductManagement\ReadModel;

use App\ProductManagement\Shared\ProductId;

class Product
{
    public function __construct(
        public readonly ProductId $id,
        public readonly string $name,
        public readonly string $description,
        public readonly float $price,
        public readonly float $vat,
    ) {
    }
}
