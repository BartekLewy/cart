<?php

declare(strict_types=1);

namespace App\ProductManagement\DomainModel;

use App\ProductManagement\Shared\ProductId;

class Product
{
    public function __construct(
        private ProductId $id,
        private ProductName $name,
        private ProductDescription $description,
        private Category $category,
        private Price $price,
    ) {
    }

    public static function create(
        ProductId $id,
        ProductName $productName,
        ProductDescription $productDescription,
        Category $category,
    ): self {
        return new self(
            $id,
            $productName,
            $productDescription,
            $category,
            Price::zero(),
        );
    }

    public function changePrice(Price $price): void
    {
        if (!$this->price->equals($price)) {
            $this->price = $price;
        }
    }
}
