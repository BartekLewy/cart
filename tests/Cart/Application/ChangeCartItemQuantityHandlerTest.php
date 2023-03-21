<?php

declare(strict_types=1);

namespace App\Tests\Cart\Application;

use App\Cart\Application\ChangeCartItemQuantity;
use App\Cart\Application\ChangeCartItemQuantityHandler;
use App\Cart\DomainModel\Cart;
use App\Cart\DomainModel\CartItem;
use App\Cart\Shared\CartId;
use App\Cart\Shared\CartItemId;
use App\Cart\Shared\ProductId;
use App\Tests\Cart\DomainModel\InMemoryCartRepository;
use App\Tests\Cart\ObjectMother\ProductObjectMother;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

class ChangeCartItemQuantityHandlerTest extends TestCase
{
    public function testChangeCartItemQuantity(): void
    {
        $cartId = CartId::generate();
        $cart = Cart::create($cartId);
        $productId = ProductId::generate();
        $cart->addCartItem(
            CartItem::one(
                CartItemId::generate(),
                ProductObjectMother::productWithId($productId),
                $cart
            )
        );
        $cartRepository = new InMemoryCartRepository();
        $cartRepository->save($cart);

        $handler = new ChangeCartItemQuantityHandler($cartRepository);
        $handler(new ChangeCartItemQuantity($cartId, $productId, 5));

        assertSame(5, $cartRepository->get($cart->id)->itemsNumber());
    }
}
