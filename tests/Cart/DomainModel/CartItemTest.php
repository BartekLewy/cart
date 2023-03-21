<?php

declare(strict_types=1);

namespace App\Tests\Cart\DomainModel;

use App\Cart\DomainModel\Cart;
use App\Cart\DomainModel\CartItem;
use App\Cart\Shared\CartId;
use App\Cart\Shared\CartItemId;
use App\Tests\Cart\ObjectMother\ProductObjectMother;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

class CartItemTest extends TestCase
{
    public function testShouldCreateCartItem(): void
    {
        $cart = Cart::create(CartId::generate());
        $cartItem = CartItem::one(CartItemId::generate(), ProductObjectMother::productWithPrice(20, 0.07), $cart);

        assertSame(20.00, $cartItem->totalPrice());
        assertSame(21.40, $cartItem->totalPriceGross());
        assertSame(1, $cartItem->quantity());
    }

    public function testShouldChangeQuantity(): void
    {
        // given
        $cart = Cart::create(CartId::generate());
        $cartItem = CartItem::one(CartItemId::generate(), ProductObjectMother::productWithPrice(20, 0.07), $cart);

        // when
        $cartItem->changeQuantity(2);

        // then
        assertSame(40.00, $cartItem->totalPrice());
        assertSame(42.80, $cartItem->totalPriceGross());
        assertSame(2, $cartItem->quantity());
    }
}
