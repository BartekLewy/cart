<?php

declare(strict_types=1);

namespace App\ProductManagement\Application;

use App\ProductManagement\ReadModel\Product;
use App\ProductManagement\ReadModel\ProductRepositoryInterface;
use App\ProductManagement\Shared\CategoryId;

class GetProducts
{
    public function __construct(private readonly ProductRepositoryInterface $repository)
    {
    }

    /** @return Product[] */
    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    /** @return Product[] */
    public function getAllByCategoryId(CategoryId $categoryId): array
    {
        return $this->repository->getAllByCategoryId($categoryId);
    }
}
