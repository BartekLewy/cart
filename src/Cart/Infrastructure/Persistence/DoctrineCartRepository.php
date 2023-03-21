<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Persistence;

use App\Cart\DomainModel\Cart;
use App\Cart\DomainModel\CartRepositoryInterface;
use App\Cart\Shared\CartId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineCartRepository extends ServiceEntityRepository implements CartRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    /** @return Cart[] */
    public function getAll(): array
    {
        return $this
            ->getEntityManager()
            ->getRepository(Cart::class)
            ->findAll()
        ;
    }

    public function get(CartId $cartId): Cart
    {
        $cart = $this
            ->getEntityManager()
            ->getRepository(Cart::class)
            ->findOneBy(['id' => $cartId])
        ;

        if (!$cart) {
            throw new \Exception('Cart not found');
        }

        return $cart;
    }

    public function save(Cart $cart): void
    {
        foreach ($cart->items() as $item) {
            $this->getEntityManager()->persist($item);
            $this->getEntityManager()->flush($item);
        }

        $this->getEntityManager()->persist($cart);
        $this->getEntityManager()->flush($cart);
    }
}
