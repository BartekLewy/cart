<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\DomainModel\Action\AddCartItemToCart as DomainAction;

final class AddCartItemToCartHandler
{
    public function __construct(private readonly DomainAction $addCartItemToCart)
    {
    }

    public function __invoke(AddCartItemToCart $command): void
    {
        $this->addCartItemToCart->addCartItem($command->cartId, $command->productId);
    }
}
