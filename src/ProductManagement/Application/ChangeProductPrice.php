<?php

declare(strict_types=1);

namespace App\ProductManagement\Application;

use App\ProductManagement\Shared\ProductId;

class ChangeProductPrice
{
    public function __construct(
        public readonly ProductId $productId,
        public readonly float $price,
        public readonly float $vat,
    ) {
    }
}
