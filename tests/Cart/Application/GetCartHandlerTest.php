<?php

declare(strict_types=1);

namespace App\Tests\Cart\Application;

use App\Cart\Application\GetCart;
use App\Cart\Application\GetCartHandler;
use App\Cart\ReadModel\Cart;
use App\Cart\Shared\CartId;
use App\Tests\Cart\ObjectMother\ReadModelCartObjectMother;
use App\Tests\Cart\ReadModel\InMemoryCartRepository;
use PHPUnit\Framework\TestCase;

class GetCartHandlerTest extends TestCase
{
    public function testGetCart(): void
    {
        // given
        $cartId = CartId::generate();
        $cart = ReadModelCartObjectMother::withId($cartId);
        $repository = new InMemoryCartRepository();
        $repository->save($cart);

        $handler = new GetCartHandler($repository);
        $handler(new GetCart($cartId));

        self::assertInstanceOf(Cart::class, $cart);
        self::assertSame($cart, $repository->get($cartId));
    }
}
