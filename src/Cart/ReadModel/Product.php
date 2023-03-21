<?php

declare(strict_types=1);

namespace App\Cart\ReadModel;

use App\Cart\Shared\ProductId;

class Product
{
    public function __construct(
        public readonly ProductId $id,
        public readonly string $name,
        public readonly string $description,
        public readonly float $price,
        public readonly float $vat
    ) {
    }
}
