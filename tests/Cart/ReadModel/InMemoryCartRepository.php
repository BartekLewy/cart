<?php

declare(strict_types=1);

namespace App\Tests\Cart\ReadModel;

use App\Cart\ReadModel\Cart;
use App\Cart\ReadModel\CartRepositoryInterface;
use App\Cart\Shared\CartId;

class InMemoryCartRepository implements CartRepositoryInterface
{
    private array $carts = [];

    public function get(CartId $id): Cart
    {
        return $this->carts[$id->id()];
    }

    public function save(Cart $cart): void
    {
        $this->carts[$cart->id->id()] = $cart;
    }
}
