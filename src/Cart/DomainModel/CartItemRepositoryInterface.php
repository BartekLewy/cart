<?php

declare(strict_types=1);

namespace App\Cart\DomainModel;

use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;

interface CartItemRepositoryInterface
{
    public function findCartItem(ProductId $productId, CartId $cartId): ?CartItem;

    public function save(CartItem $cartItem): void;
}
