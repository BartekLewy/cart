<?php

declare(strict_types=1);

namespace App\Tests\Cart\DomainModel;

use App\Cart\DomainModel\Cart;
use App\Cart\DomainModel\CartItem;
use App\Cart\Shared\CartId;
use App\Cart\Shared\CartItemId;
use App\Cart\Shared\ProductId;
use App\Tests\Cart\ObjectMother\ProductObjectMother;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

class CartTest extends TestCase
{
    public function testShouldCreateEmptyCart(): void
    {
        // given
        $cart = Cart::create(CartId::generate());

        // then
        assertSame(0.00, $cart->totalPrice());
        assertSame(0.00, $cart->totalPriceGross());
        assertSame([], $cart->items());
        assertSame(0, $cart->itemsNumber());
    }

    public function testShouldAddOneItemToCart(): void
    {
        // given
        $cart = Cart::create(CartId::generate());
        // when
        $cart->addCartItem(CartItem::one(CartItemId::generate(), ProductObjectMother::productWithPrice(20, 0.07), $cart));

        // then
        assertSame(20.00, $cart->totalPrice());
        assertSame(21.40, $cart->totalPriceGross());
        assertCount(1, $cart->items());
        assertSame(1, $cart->itemsNumber());
    }

    public function testShouldAddOneItemToCartTwice(): void
    {
        // given
        $cart = Cart::create(CartId::generate());
        $cartItem = CartItem::one(CartItemId::generate(), ProductObjectMother::productWithId(ProductId::generate()), $cart);

        // when
        $cart->addCartItem($cartItem);
        $cart->addCartItem($cartItem);

        // then
        assertSame(20.00, $cart->totalPrice());
        assertSame(22.00, $cart->totalPriceGross());
        assertCount(1, $cart->items());
        assertSame(2, $cart->itemsNumber());
    }

    public function testShouldAddTwoDifferentItemsToCart(): void
    {
        // given
        $cart = Cart::create(CartId::generate());
        $cartItem = CartItem::one(CartItemId::generate(), ProductObjectMother::productWithPrice(20, 0.07), $cart);
        $cartItem2 = CartItem::one(CartItemId::generate(), ProductObjectMother::productWithPrice(30, 0.07), $cart);

        // when
        $cart->addCartItem($cartItem);
        $cart->addCartItem($cartItem2);

        // then
        assertSame(50.00, $cart->totalPrice());
        assertSame(53.50, $cart->totalPriceGross());
        assertCount(2, $cart->items());
        assertSame(2, $cart->itemsNumber());
    }

    public function testShouldAddAndProductAndThenChangeQuantity(): void
    {
        // given
        $cart = Cart::create(CartId::generate());
        $cartItem = CartItem::one(CartItemId::generate(), ProductObjectMother::productWithPrice(20, 0.07), $cart);

        // when
        $cart->addCartItem($cartItem);
        $cart->changeCartItemQuantity($cartItem->product->id(), 10);

        // then
        assertSame(200.00, $cart->totalPrice());
        assertSame(214.00, $cart->totalPriceGross());
        assertSame(10, $cart->itemsNumber());
    }

    public function testShouldAddTwoProductsAndRemoveSecond(): void
    {
        // given
        $cart = Cart::create(CartId::generate());
        $cartItem = CartItem::one(CartItemId::generate(), ProductObjectMother::productWithPrice(30, 0.07), $cart);
        $cartItem2 = CartItem::one(CartItemId::generate(), ProductObjectMother::productWithPrice(20, 0.07), $cart);

        // when
        $cart->addCartItem($cartItem);
        $cart->addCartItem($cartItem2);
        $cart->removeCartItem($cartItem->product->id());

        // then
        assertSame(20.00, $cart->totalPrice());
        assertSame(21.40, $cart->totalPriceGross());
        assertCount(1, $cart->items());
        assertSame(1, $cart->itemsNumber());
    }
}
