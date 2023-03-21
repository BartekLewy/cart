<?php

namespace App\Tests\Cart\Application;

use App\Cart\Application\RemoveCartItemFromCart;
use App\Cart\Application\RemoveCartItemFromCartHandler;
use App\Cart\DomainModel\CartItem;
use App\Cart\Shared\CartId;
use App\Cart\Shared\CartItemId;
use App\Cart\Shared\ProductId;
use App\Tests\Cart\DomainModel\InMemoryCartRepository;
use App\Tests\Cart\ObjectMother\CartObjectMother;
use App\Tests\Cart\ObjectMother\ProductObjectMother;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

class RemoveCartItemFromCartHandlerTest extends TestCase
{
    public function testRemoveCartItemFromCart(): void
    {
        $cartId = CartId::generate();
        $cart = CartObjectMother::withId($cartId);
        $productId = ProductId::generate();
        $cart->addCartItem(
            CartItem::one(
                CartItemId::generate(),
                ProductObjectMother::productWithId($productId),
                $cart
            )
        );
        $repository = new InMemoryCartRepository();
        $repository->save($cart);

        assertCount(1, $cart->items());

        $handler = new RemoveCartItemFromCartHandler($repository);
        $handler(new RemoveCartItemFromCart($cartId, $productId));

        assertSame(0, $repository->get($cartId)->itemsNumber());
    }
}
