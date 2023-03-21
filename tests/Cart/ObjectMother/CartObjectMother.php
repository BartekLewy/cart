<?php

declare(strict_types=1);

namespace App\Tests\Cart\ObjectMother;

use App\Cart\DomainModel\Cart;
use App\Cart\Shared\CartId;

final class CartObjectMother
{
    public static function anEmptyCart(): Cart
    {
        return Cart::create(CartId::generate());
    }

    public static function withId(CartId $id): Cart
    {
        return Cart::create($id);
    }
}
