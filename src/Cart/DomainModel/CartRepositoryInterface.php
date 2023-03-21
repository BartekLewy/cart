<?php

namespace App\Cart\DomainModel;

use App\Cart\Shared\CartId;

interface CartRepositoryInterface
{
    /** @return Cart[] */
    public function getAll(): array;

    public function get(CartId $cartId): Cart;

    public function save(Cart $cart): void;
}
