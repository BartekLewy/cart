<?php

declare(strict_types=1);

namespace App\Cart\ReadModel;

use App\Cart\Shared\CartId;

interface CartRepositoryInterface
{
    public function get(CartId $id): Cart;
}
