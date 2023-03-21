<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;

final class RemoveCartItemFromCart
{
    public function __construct(
        public readonly CartId $cartId,
        public readonly ProductId $productId,
    ) {
    }
}
