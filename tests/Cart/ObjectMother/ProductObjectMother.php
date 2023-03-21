<?php

declare(strict_types=1);

namespace App\Tests\Cart\ObjectMother;

use App\Cart\DomainModel\Product;
use App\Cart\Shared\ProductId;

final class ProductObjectMother
{
    public static function any(): Product
    {
        return new Product(
            ProductId::generate(),
            10.00,
            0.1
        );
    }

    public static function productWithPrice(float $price, float $vat): Product
    {
        return new Product(
            ProductId::generate(),
            $price,
            $vat,
        );
    }

    public static function productWithId(ProductId $id): Product
    {
        return new Product(
            $id,
            10.00,
            0.1
        );
    }
}
