<?php

declare(strict_types=1);

namespace App\ProductManagement\Application;

use App\ProductManagement\ReadModel\Category;
use App\ProductManagement\ReadModel\CategoryRepositoryInterface;

class GetCategories
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /** @return Category[] */
    public function getAll(): array
    {
        return $this->categoryRepository->getAll();
    }
}
