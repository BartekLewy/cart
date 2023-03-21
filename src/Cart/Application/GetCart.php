<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\Shared\CartId;

final class GetCart
{
    public function __construct(
        public readonly CartId $cartId,
    ) {
    }
}
