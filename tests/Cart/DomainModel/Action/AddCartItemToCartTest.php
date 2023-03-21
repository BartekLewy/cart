<?php

declare(strict_types=1);

namespace App\Tests\Cart\DomainModel\Action;

use App\Cart\DomainModel\Action\AddCartItemToCart;
use App\Tests\Cart\DomainModel\InMemoryCartItemRepository;
use App\Tests\Cart\DomainModel\InMemoryCartRepository;
use App\Tests\Cart\DomainModel\InMemoryProductRepository;
use App\Tests\Cart\ObjectMother\CartObjectMother;
use App\Tests\Cart\ObjectMother\ProductObjectMother;
use PHPUnit\Framework\TestCase;

class AddCartItemToCartTest extends TestCase
{
    private AddCartItemToCart $sut;
    private InMemoryCartRepository $cartRepository;
    private InMemoryCartItemRepository $cartItemRepository;
    private InMemoryProductRepository $productRepository;

    public function setUp(): void
    {
        $this->cartRepository = new InMemoryCartRepository();
        $this->cartItemRepository = new InMemoryCartItemRepository();
        $this->productRepository = new InMemoryProductRepository();

        $this->sut = new AddCartItemToCart(
            $this->cartRepository,
            $this->cartItemRepository,
            $this->productRepository,
        );
    }

    protected function tearDown(): void
    {
        $this->cartRepository->clear();
        $this->cartItemRepository->clear();
        $this->productRepository->clear();
    }

    public function testShouldAddCartItemToCart(): void
    {
        // given
        $cart = CartObjectMother::anEmptyCart();
        $this->cartRepository->save($cart);
        $product = ProductObjectMother::any();
        $this->productRepository->save($product);

        // when
        $this->sut->addCartItem($cart->id, $product->id());

        // then
        $this->assertSame(10.00, $cart->totalPrice());
        $this->assertSame(11.00, $cart->totalPriceGross());
        $this->assertCount(1, $cart->items());
        $this->assertSame(1, $cart->itemsNumber());
    }

    public function testShouldAddCartItemToCartTwice(): void
    {
        // given
        $cart = CartObjectMother::anEmptyCart();
        $this->cartRepository->save($cart);
        $product = ProductObjectMother::any();
        $this->productRepository->save($product);

        // when
        $this->sut->addCartItem($cart->id, $product->id());
        $this->sut->addCartItem($cart->id, $product->id());

        // then
        $this->assertSame(20.00, $cart->totalPrice());
        $this->assertSame(22.00, $cart->totalPriceGross());
        $this->assertCount(1, $cart->items());
        $this->assertSame(2, $cart->itemsNumber());
    }

    public function testShouldAddCartItemToCartTwiceWithDifferentProducts(): void
    {
        // given
        $cart = CartObjectMother::anEmptyCart();
        $this->cartRepository->save($cart);
        $product1 = ProductObjectMother::any();
        $this->productRepository->save($product1);
        $product2 = ProductObjectMother::any();
        $this->productRepository->save($product2);

        // when
        $this->sut->addCartItem($cart->id, $product1->id());
        $this->sut->addCartItem($cart->id, $product2->id());

        // then
        $this->assertSame(20.00, $cart->totalPrice());
        $this->assertSame(22.00, $cart->totalPriceGross());
        $this->assertCount(2, $cart->items());
        $this->assertSame(2, $cart->itemsNumber());
    }
}
