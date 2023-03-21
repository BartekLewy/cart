<?php

declare(strict_types=1);

namespace App\ProductManagement\Infrastructure\Persistence;

use App\ProductManagement\DomainModel\Category;
use App\ProductManagement\DomainModel\CategoryRepositoryInterface;
use App\ProductManagement\Shared\CategoryId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineCategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function get(CategoryId $id): Category
    {
        return $this
            ->getEntityManager()
            ->getRepository(Category::class)
            ->findOneBy(['id' => $id])
        ;
    }

    public function findByName(string $name): Category
    {
        return $this
            ->getEntityManager()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $name])
        ;
    }
}
