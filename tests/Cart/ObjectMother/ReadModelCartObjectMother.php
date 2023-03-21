<?php

declare(strict_types=1);

namespace App\Tests\Cart\ObjectMother;

use App\Cart\ReadModel\Cart;
use App\Cart\ReadModel\CartItem;
use App\Cart\Shared\CartId;
use App\Cart\Shared\CartItemId;
use App\Cart\Shared\ProductId;

class ReadModelCartObjectMother
{
    public static function withId(CartId $cartId): Cart
    {
        $cartItems = [
            self::aCartItem(),
            self::aCartItem(),
            self::aCartItem(),
        ];

        return new Cart(
            $cartId,
            $cartItems,
            array_reduce(
                $cartItems,
                fn (float $total, CartItem $item) => $total + $item->totalPrice,
                0
            ),
            array_reduce(
                $cartItems,
                fn (float $total, CartItem $item) => $total + $item->totalPriceGross,
                0
            )
        );
    }

    public static function aCartItem(): CartItem
    {
        return new CartItem(
            CartItemId::generate()->id(),
            ProductId::generate()->id(),
            'Product name',
            1,
            10.00,
            12.30,
            0.23
        );
    }
}
