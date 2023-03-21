<?php

declare(strict_types=1);

namespace App\Cart\DomainModel\Action;

use App\Cart\DomainModel\Cart;
use App\Cart\DomainModel\CartItem;
use App\Cart\DomainModel\CartItemRepositoryInterface;
use App\Cart\DomainModel\CartRepositoryInterface;
use App\Cart\DomainModel\Product;
use App\Cart\DomainModel\ProductRepositoryInterface;
use App\Cart\Shared\CartId;
use App\Cart\Shared\CartItemId;
use App\Cart\Shared\ProductId;

class AddCartItemToCart
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly CartItemRepositoryInterface $cartItemRepository,
        private readonly ProductRepositoryInterface $productRepository,
    ) {
    }

    public function addCartItem(CartId $cartId, ProductId $productId): void
    {
        $product = $this->productRepository->get($productId);
        $cart = $this->cartRepository->get($cartId);

        if ($cartItem = $this->getCartItem($cart->id, $product->id())) {
            $cart->changeCartItemQuantity($product->id(), $cartItem->quantity() + 1);
        } else {
            $cartItem = $this->createCartItemFromProduct($product, $cart);
            $cart->addCartItem($cartItem);
        }

        $this->cartRepository->save($cart);
    }

    private function getCartItem(CartId $cartId, ProductId $productId): ?CartItem
    {
        return $this->cartItemRepository->findCartItem($productId, $cartId);
    }

    private function createCartItemFromProduct(Product $product, Cart $cart): CartItem
    {
        $cartItem = CartItem::one(
            CartItemId::generate(),
            $product,
            $cart,
        );

        $this->cartItemRepository->save($cartItem);

        return $cartItem;
    }
}
