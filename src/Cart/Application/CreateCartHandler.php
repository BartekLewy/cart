<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\DomainModel\Cart;
use App\Cart\DomainModel\CartRepositoryInterface;

final class CreateCartHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {
    }

    public function __invoke(CreateCart $command): void
    {
        $this->cartRepository->save(Cart::create($command->id));
    }
}
