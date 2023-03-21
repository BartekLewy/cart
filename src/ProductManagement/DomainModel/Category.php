<?php

declare(strict_types=1);

namespace App\ProductManagement\DomainModel;

use App\ProductManagement\Shared\CategoryId;

class Category
{
    public function __construct(
        public readonly CategoryId $id,
        public readonly string $name,
    ) {
    }
}
