<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Persistence;

use App\Cart\DomainModel\Product;
use App\Cart\DomainModel\ProductRepositoryInterface;
use App\Cart\Shared\ProductId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function get(ProductId $productId): Product
    {
        return $this->find($productId) ?? throw new \Exception('Product not found');
    }

    /** @return Product[] */
    public function getAll(): array
    {
        return $this->findAll();
    }
}
