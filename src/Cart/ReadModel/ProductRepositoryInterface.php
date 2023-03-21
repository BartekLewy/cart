<?php

declare(strict_types=1);

namespace App\Cart\ReadModel;

interface ProductRepositoryInterface
{
    /** @return Product[] */
    public function getAll(): array;
}
