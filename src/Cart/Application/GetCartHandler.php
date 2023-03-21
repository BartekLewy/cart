<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\ReadModel\CartRepositoryInterface;

final class GetCartHandler
{
    public function __construct(private readonly CartRepositoryInterface $cartRepository)
    {
    }

    public function __invoke(GetCart $cart)
    {
        return $this->cartRepository->get($cart->cartId);
    }
}
