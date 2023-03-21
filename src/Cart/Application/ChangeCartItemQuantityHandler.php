<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\DomainModel\CartRepositoryInterface;

final class ChangeCartItemQuantityHandler
{
    public function __construct(private readonly CartRepositoryInterface $cartRepository)
    {
    }

    public function __invoke(ChangeCartItemQuantity $command): void
    {
        $cart = $this->cartRepository->get($command->cartId);
        $cart->changeCartItemQuantity($command->productId, $command->quantity);

        $this->cartRepository->save($cart);
    }
}
