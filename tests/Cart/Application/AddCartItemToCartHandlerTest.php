<?php

declare(strict_types=1);

namespace App\Tests\Cart\Application;

use App\Cart\Application\AddCartItemToCart;
use App\Cart\Application\AddCartItemToCartHandler;
use App\Cart\DomainModel\Action\AddCartItemToCart as DomainAddCartItemToCart;
use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;
use App\Tests\Cart\DomainModel\InMemoryCartItemRepository;
use App\Tests\Cart\DomainModel\InMemoryCartRepository;
use App\Tests\Cart\DomainModel\InMemoryProductRepository;
use App\Tests\Cart\ObjectMother\CartObjectMother;
use App\Tests\Cart\ObjectMother\ProductObjectMother;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;

class AddCartItemToCartHandlerTest extends TestCase
{
    public function testAddCartItemToCart(): void
    {
        $cartId = CartId::generate();
        $cartRepository = new InMemoryCartRepository();
        $cartRepository->save(CartObjectMother::withId($cartId));

        $productRepository = new InMemoryProductRepository();
        $productId = ProductId::generate();
        $productRepository->save(ProductObjectMother::productWithId($productId));

        $addCartItemToCart = new DomainAddCartItemToCart(
            $cartRepository,
            new InMemoryCartItemRepository(),
            $productRepository
        );

        $handler = new AddCartItemToCartHandler($addCartItemToCart);
        $handler(new AddCartItemToCart($cartId, $productId));

        assertCount(1, $cartRepository->get($cartId)->items());
    }
}
