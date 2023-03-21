<?php

declare(strict_types=1);

namespace App\ProductManagement\ReadModel;

use App\ProductManagement\Shared\CategoryId;

interface ProductRepositoryInterface
{
    /** @return Product[] */
    public function getAll(): array;

    /** @return Product[] */
    public function getAllByCategoryId(CategoryId $categoryId): array;
}
