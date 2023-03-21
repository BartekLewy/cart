<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\DomainModel\CartRepositoryInterface;

final class RemoveCartItemFromCartHandler
{
    public function __construct(private readonly CartRepositoryInterface $cartRepository)
    {
    }

    public function __invoke(RemoveCartItemFromCart $command): void
    {
        $cart = $this->cartRepository->get($command->cartId);
        $cart->removeCartItem($command->productId);

        $this->cartRepository->save($cart);
    }
}
