<?php

declare(strict_types=1);

namespace App\Cart\DomainModel;

use App\Cart\Shared\ProductId;

class Product
{
    public function __construct(
        private ProductId $id,
        public readonly float $price,
        public readonly float $vat,
    ) {
    }

    public function id(): ProductId
    {
        return $this->id;
    }
}
