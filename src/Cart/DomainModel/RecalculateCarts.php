<?php

declare(strict_types=1);

namespace App\Cart\DomainModel;

use App\Cart\Contracts\RecalculateCartsInterface;
use App\Cart\Shared\ProductId;
use App\Shared\Identity;

class RecalculateCarts implements RecalculateCartsInterface
{
    public function __construct(private CartRepositoryInterface $cartRepository)
    {
    }

    public function afterProductPriceChange(Identity $productId): void
    {
        $productId = ProductId::fromIdentity($productId);

        $carts = $this->cartRepository->getAll();

        foreach ($carts as $cart) {
            foreach ($cart->items() as $cartItem) {
                if ($cartItem->product->id()->equals($productId)) {
                    $cartItem->calculate();
                    $cart->calculate();
                    $this->cartRepository->save($cart);
                }
            }
        }
    }
}
