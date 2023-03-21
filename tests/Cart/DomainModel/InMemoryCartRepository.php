<?php

declare(strict_types=1);

namespace App\Tests\Cart\DomainModel;

use App\Cart\DomainModel\Cart;
use App\Cart\DomainModel\CartRepositoryInterface;
use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;

final class InMemoryCartRepository implements CartRepositoryInterface
{
    private array $carts = [];

    /** @return Cart[] */
    public function getAll(): array
    {
        return $this->carts;
    }

    public function save(Cart $cart): void
    {
        $this->carts[$cart->id->id()] = $cart;
    }

    public function get(CartId $cartId): Cart
    {
        return $this->carts[$cartId->id()];
    }

    public function changePrice(ProductId $productId, float $price): void
    {
    }

    public function clear(): void
    {
        $this->carts = [];
    }
}
