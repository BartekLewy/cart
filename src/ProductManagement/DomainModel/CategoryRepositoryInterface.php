<?php

declare(strict_types=1);

namespace App\ProductManagement\DomainModel;

use App\ProductManagement\Shared\CategoryId;

interface CategoryRepositoryInterface
{
    public function get(CategoryId $id): Category;

    /** @return Category[] */
    public function findByName(string $name): Category;
}
