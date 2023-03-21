<?php

declare(strict_types=1);

namespace App\Tests\Cart\Application;

use App\Cart\Application\CreateCart;
use App\Cart\Application\CreateCartHandler;
use App\Cart\DomainModel\Cart;
use App\Cart\Shared\CartId;
use App\Tests\Cart\DomainModel\InMemoryCartRepository;
use PHPUnit\Framework\TestCase;

class CreateCartHandlerTest extends TestCase
{
    public function testCreateCart(): void
    {
        $cartId = CartId::generate();

        $repository = new InMemoryCartRepository();
        $handler = new CreateCartHandler($repository);

        $handler(new CreateCart($cartId));

        $cart = $repository->get($cartId);
        self::assertInstanceOf(Cart::class, $cart);
        self::assertSame($cartId, $cart->id);
    }
}
