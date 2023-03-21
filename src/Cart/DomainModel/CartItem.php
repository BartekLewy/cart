<?php

declare(strict_types=1);

namespace App\Cart\DomainModel;

use App\Cart\Shared\CartItemId;

class CartItem
{
    public function __construct(
        public readonly CartItemId $id,
        public readonly Product $product,
        public readonly Cart $cart,
        private int $quantity,
        private float $totalPrice,
        private float $totalPriceGross,
        private float $vat
    ) {
    }

    public static function one(CartItemId $id, Product $product, Cart $cart): self
    {
        return new self(
            $id,
            $product,
            $cart,
            1,
            $product->price,
            $product->price * $product->vat + $product->price,
            $product->vat
        );
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function totalPrice(): float
    {
        return $this->totalPrice;
    }

    public function totalPriceGross(): float
    {
        return $this->totalPriceGross;
    }

    public function vat(): float
    {
        return $this->vat;
    }

    public function changeQuantity(int $quantity): void
    {
        if ($quantity < 1) {
            throw new \InvalidArgumentException('Quantity can not be lower than 1');
        }

        $this->quantity = $quantity;
        $this->calculate();
    }

    public function calculate(): void
    {
        $this->totalPrice = $this->product->price * $this->quantity;
        $this->totalPriceGross = $this->product->price * $this->quantity * $this->product->vat + $this->totalPrice;
    }
}
