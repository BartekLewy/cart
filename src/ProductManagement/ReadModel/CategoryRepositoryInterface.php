<?php

declare(strict_types=1);

namespace App\ProductManagement\ReadModel;

interface CategoryRepositoryInterface
{
    public function getAll(): array;
}
