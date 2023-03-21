<?php

declare(strict_types=1);

namespace App\ProductManagement\Application;

use App\ProductManagement\DomainModel\CategoryRepositoryInterface;
use App\ProductManagement\DomainModel\Product;
use App\ProductManagement\DomainModel\ProductDescription;
use App\ProductManagement\DomainModel\ProductName;
use App\ProductManagement\DomainModel\ProductRepositoryInterface;

class AddProductHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(AddProduct $command): void
    {
        $product = Product::create(
            $command->productId,
            new ProductName($command->name),
            new ProductDescription($command->description),
            $this->categoryRepository->get($command->categoryId),
        );

        $this->productRepository->save($product);
    }
}
