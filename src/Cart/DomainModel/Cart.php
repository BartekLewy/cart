<?php

declare(strict_types=1);

namespace App\Cart\DomainModel;

use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;

class Cart
{
    public function __construct(
        public readonly CartId $id,
        /** @var CartItem[] $items */
        private mixed $items,
        private float $totalPrice,
        private float $totalPriceGross,
    ) {
    }

    public static function create(CartId $cartId): self
    {
        return new self($cartId, [], 0, 0);
    }

    public function addCartItem(CartItem $cartItem): void
    {
        foreach ($this->items as $item) {
            if ($item->id->equals($cartItem->id) && $item->product->id()->equals($cartItem->product->id())) {
                $item->changeQuantity($item->quantity() + 1);
                $this->calculate();

                return;
            }
        }

        $this->items[] = $cartItem;
        $this->calculate();
    }

    public function changeCartItemQuantity(ProductId $productId, int $quantity): void
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Quantity must be greater than 0');
        }

        foreach ($this->items as $item) {
            if ($item->product->id()->equals($productId)) {
                $item->changeQuantity($quantity);
            }
        }

        $this->calculate();
    }

    public function removeCartItem(ProductId $productId): void
    {
        foreach ($this->items as $key => $item) {
            if ($item->product->id()->equals($productId)) {
                unset($this->items[$key]);
            }
        }

        $this->calculate();
    }

    public function calculate(): void
    {
        $this->totalPrice = 0;
        $this->totalPriceGross = 0;

        foreach ($this->items as $item) {
            $this->totalPrice += $item->totalPrice();
            $this->totalPriceGross += $item->totalPriceGross();
        }
    }

    /**
     * @return CartItem[]
     */
    public function items()
    {
        return $this->items;
    }

    public function itemsNumber(): int
    {
        return array_reduce($this->items, fn (int $sum, CartItem $item) => $sum += $item->quantity(), 0);
    }

    public function totalPrice(): float
    {
        return $this->totalPrice;
    }

    public function totalPriceGross(): float
    {
        return $this->totalPriceGross;
    }
}
