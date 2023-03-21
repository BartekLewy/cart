<?php

declare(strict_types=1);

namespace App\Cart\Contracts;

use App\Shared\Identity;

interface RecalculateCartsInterface
{
    public function afterProductPriceChange(Identity $productId): void;
}
