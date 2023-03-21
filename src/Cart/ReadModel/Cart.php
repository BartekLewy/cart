<?php

declare(strict_types=1);

namespace App\Cart\ReadModel;

use App\Cart\Shared\CartId;

class Cart
{
    public function __construct(
        public readonly CartId $id,
        /** @var CartItem[] */
        public readonly array $items,
        public readonly float $totalPrice,
        public readonly float $totalPriceGross
    ) {
    }
}
