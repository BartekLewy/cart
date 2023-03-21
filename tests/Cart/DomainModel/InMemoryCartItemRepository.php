<?php

declare(strict_types=1);

namespace App\Tests\Cart\DomainModel;

use App\Cart\DomainModel\CartItem;
use App\Cart\DomainModel\CartItemRepositoryInterface;
use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;

class InMemoryCartItemRepository implements CartItemRepositoryInterface
{
    /** @var CartItem[] */
    private array $cartItems = [];

    public function save(CartItem $cartItem): void
    {
        $this->cartItems[$cartItem->id->id()] = $cartItem;
    }

    public function findCartItem(ProductId $productId, CartId $cartId): ?CartItem
    {
        foreach ($this->cartItems as $cartItem) {
            if ($cartItem->product->id()->id() === $productId->id() && $cartItem->cart->id->id() === $cartId->id()) {
                return $cartItem;
            }
        }

        return null;
    }

    public function clear(): void
    {
        $this->cartItems = [];
    }
}
