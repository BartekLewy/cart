<?php

declare(strict_types=1);

namespace App\ProductManagement\Infrastructure\Persistence;

use App\ProductManagement\DomainModel\Product;
use App\ProductManagement\Shared\ProductId;
use App\ProductManagement\DomainModel\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product): void
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    public function get(ProductId $productId): Product
    {
        $product = $this
            ->getEntityManager()
            ->getRepository(Product::class)
            ->findOneBy(['id' => $productId])
        ;

        if (!$product) {
            throw new \Exception('Product not found');
        }

        return $product;
    }
}
