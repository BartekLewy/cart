<?php

declare(strict_types=1);

namespace App\ProductManagement\DomainModel;

class ProductName
{
    private string $name;

    public function __construct(string $name)
    {
        if (mb_strlen($name) < 3) {
            throw new \InvalidArgumentException('Product name must be at least 3 characters long');
        }

        $this->name = $name;
    }
}
