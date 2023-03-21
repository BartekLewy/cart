<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Persistence;

use App\Cart\DomainModel\CartItem;
use App\Cart\DomainModel\CartItemRepositoryInterface;
use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineCartItemRepository extends ServiceEntityRepository implements CartItemRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartItem::class);
    }

    public function findCartItem(ProductId $productId, CartId $cartId): ?CartItem
    {
        return $this
            ->getEntityManager()
            ->getRepository(CartItem::class)
            ->findOneBy([
                'product' => $productId,
                'cart' => $cartId,
            ])
        ;
    }

    public function save(CartItem $cartItem): void
    {
        $this->getEntityManager()->persist($cartItem);
        $this->getEntityManager()->flush();
    }
}
