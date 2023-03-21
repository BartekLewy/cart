<?php

declare(strict_types=1);

namespace App\Cart\ReadModel;

class CartItem
{
    public function __construct(
        public readonly string $id,
        public readonly string $productId,
        public readonly string $name,
        public readonly int $quantity,
        public readonly float $totalPrice,
        public readonly float $totalPriceGross,
        public readonly float $vatRate
    ) {
    }
}
