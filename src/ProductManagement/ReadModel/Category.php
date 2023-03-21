<?php

declare(strict_types=1);

namespace App\ProductManagement\ReadModel;

use App\ProductManagement\Shared\CategoryId;

class Category
{
    public function __construct(
        public readonly CategoryId $id,
        public readonly string $name
    ) {
    }
}
