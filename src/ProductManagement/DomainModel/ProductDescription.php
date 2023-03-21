<?php

declare(strict_types=1);

namespace App\ProductManagement\DomainModel;

class ProductDescription
{
    private string $description;

    public function __construct(string $description)
    {
        if (empty($description)) {
            throw new \InvalidArgumentException('Product description cannot be empty');
        }

        if (mb_strlen($description) > 255) {
            throw new \InvalidArgumentException('Product description cannot be longer than 255 characters');
        }

        $this->description = $description;
    }
}
