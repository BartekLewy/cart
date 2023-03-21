<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Read;

use App\Cart\ReadModel\Cart;
use App\Cart\ReadModel\CartItem;
use App\Cart\ReadModel\CartRepositoryInterface;
use App\Cart\Shared\CartId;
use Doctrine\DBAL\Connection;

class DbalCartRepository implements CartRepositoryInterface
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function get(CartId $id): Cart
    {
        $cart = $this->connection
            ->createQueryBuilder()
            ->select(
                'c.id',
                'c.total_price',
                'c.total_price as cart_total_price',
                'c.total_price_gross as cart_total_price_gross',
            )
            ->from('carts', 'c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            ->executeQuery()
            ->fetchAssociative();

        $cartItems = $this->connection
            ->createQueryBuilder()
            ->select(
                'ci.id',
                'ci.product_id',
                'ci.quantity',
                'ci.total_price',
                'ci.total_price_gross',
                'ci.vat',
                'p.name'
            )
            ->join('ci', 'carts', 'c', 'ci.cart_id = c.id')
            ->join('ci', 'products', 'p', 'ci.product_id = p.id')
            ->from('cart_items', 'ci')
            ->andWhere('ci.cart_id = :id')
            ->setParameter('id', $id)
            ->executeQuery()
            ->fetchAllAssociative();

        return new Cart(
            $id,
            $this->mapCartItems($cartItems),
            round($cart['cart_total_price'], 2),
            round($cart['cart_total_price_gross'], 2),
        );
    }

    private function mapCartItems(array $cartItems): array
    {
        return array_map(fn (array $cartItem) => $this->mapCartItem($cartItem), $cartItems);
    }

    private function mapCartItem(array $cartItem): CartItem
    {
        return new CartItem(
            $cartItem['id'],
            $cartItem['product_id'],
            $cartItem['name'],
            $cartItem['quantity'],
            round($cartItem['total_price'], 2),
            round($cartItem['total_price_gross'], 2),
            $cartItem['vat'],
        );
    }
}
